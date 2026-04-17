import { useEffect, useMemo, useState } from "react";

const API_URL = "https://jsonplaceholder.typicode.com/users";

export default function App() {
  const [users, setUsers] = useState([]);
  const [query, setQuery] = useState("");
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  useEffect(() => {
    const controller = new AbortController();

    const loadUsers = async () => {
      setLoading(true);
      setError("");

      try {
        const response = await fetch(API_URL, { signal: controller.signal });

        if (!response.ok) {
          throw new Error("Failed to fetch data.");
        }

        const data = await response.json();
        setUsers(Array.isArray(data) ? data : []);
      } catch (fetchError) {
        if (fetchError.name !== "AbortError") {
          setError("Could not load API data. Please refresh.");
        }
      } finally {
        setLoading(false);
      }
    };

    loadUsers();

    return () => {
      controller.abort();
    };
  }, []);

  const filteredUsers = useMemo(() => {
    const term = query.trim().toLowerCase();

    if (!term) {
      return users;
    }

    return users.filter((user) => {
      const searchable = [
        user.name,
        user.email,
        user.username,
        user.phone,
        user.company?.name,
        user.address?.city,
      ]
        .join(" ")
        .toLowerCase();

      return searchable.includes(term);
    });
  }, [users, query]);

  return (
    <main className="page">
      <section className="panel">
        <h1>Dynamic API Search</h1>
        <p className="subtitle">Type in the search box to instantly filter API results.</p>

        <div className="search-row">
          <input
            type="search"
            placeholder="Search by name, email, city, company..."
            value={query}
            onChange={(event) => setQuery(event.target.value)}
            aria-label="Search users"
          />
          <span className="badge">{filteredUsers.length} result(s)</span>
        </div>

        {loading && <p className="status">Loading data from API...</p>}
        {error && <p className="status error">{error}</p>}

        {!loading && !error && (
          <div className="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Username</th>
                  <th>City</th>
                  <th>Company</th>
                </tr>
              </thead>
              <tbody>
                {filteredUsers.map((user) => (
                  <tr key={user.id}>
                    <td>{user.name}</td>
                    <td>{user.email}</td>
                    <td>{user.username}</td>
                    <td>{user.address?.city || "-"}</td>
                    <td>{user.company?.name || "-"}</td>
                  </tr>
                ))}
              </tbody>
            </table>

            {!filteredUsers.length && (
              <p className="empty">No matches found for "{query}".</p>
            )}
          </div>
        )}
      </section>
    </main>
  );
}
