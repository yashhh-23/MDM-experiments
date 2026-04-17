import { useEffect, useState } from "react";

const readSavedCount = () => {
  const raw = localStorage.getItem("counterValue");
  const parsed = Number(raw);
  return Number.isFinite(parsed) ? parsed : 0;
};

export default function App() {
  const [count, setCount] = useState(readSavedCount);
  const [step, setStep] = useState(1);
  const [autoRun, setAutoRun] = useState(false);

  useEffect(() => {
    document.title = `Counter: ${count}`;
    localStorage.setItem("counterValue", String(count));
  }, [count]);

  useEffect(() => {
    if (!autoRun) {
      return undefined;
    }

    const timerId = window.setInterval(() => {
      setCount((previous) => previous + step);
    }, 1000);

    return () => {
      window.clearInterval(timerId);
    };
  }, [autoRun, step]);

  const increase = () => setCount((previous) => previous + step);
  const decrease = () => setCount((previous) => previous - step);
  const reset = () => setCount(0);

  return (
    <main className="page">
      <section className="counter-card">
        <p className="eyebrow">React Hooks Demo</p>
        <h1>Simple Counter App</h1>
        <p className="subtitle">Built with useState and useEffect</p>

        <div className="count-wrap">
          <span className="count-label">Current Count</span>
          <span className="count-value">{count}</span>
        </div>

        <div className="controls">
          <button type="button" onClick={decrease}>
            - Decrease
          </button>
          <button type="button" onClick={increase}>
            + Increase
          </button>
          <button type="button" onClick={reset}>
            Reset
          </button>
        </div>

        <div className="settings">
          <label htmlFor="step">Step Value</label>
          <input
            id="step"
            type="number"
            min="1"
            max="10"
            value={step}
            onChange={(event) => {
              const next = Number(event.target.value);
              setStep(Number.isFinite(next) && next > 0 ? next : 1);
            }}
          />

          <label className="switch">
            <input
              type="checkbox"
              checked={autoRun}
              onChange={(event) => setAutoRun(event.target.checked)}
            />
            Auto increment every second
          </label>
        </div>
      </section>
    </main>
  );
}
