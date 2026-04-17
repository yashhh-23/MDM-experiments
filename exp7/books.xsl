<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" encoding="UTF-8" indent="yes"/>

  <xsl:template match="/">
    <html>
      <head>
        <title>Book Catalog</title>
        <style>
          body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            margin: 0;
            padding: 24px;
            color: #1f2937;
          }
          h1 {
            margin: 0 0 12px;
            font-size: 28px;
          }
          table {
            border-collapse: collapse;
            width: 100%;
            max-width: 900px;
            background: #ffffff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
          }
          th, td {
            border: 1px solid #d1d5db;
            padding: 10px 12px;
            text-align: left;
          }
          th {
            background: #1d4ed8;
            color: #ffffff;
          }
          tr:nth-child(even) {
            background: #f9fafb;
          }
          .price {
            text-align: right;
            font-weight: 600;
          }
        </style>
      </head>
      <body>
        <h1>Book Details</h1>
        <table>
          <thead>
            <tr>
              <th>Title</th>
              <th>Author</th>
              <th>Price (USD)</th>
            </tr>
          </thead>
          <tbody>
            <xsl:for-each select="books/book">
              <tr>
                <td><xsl:value-of select="title"/></td>
                <td><xsl:value-of select="author"/></td>
                <td class="price">
                  <xsl:value-of select="format-number(price, '0.00')"/>
                </td>
              </tr>
            </xsl:for-each>
          </tbody>
        </table>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
