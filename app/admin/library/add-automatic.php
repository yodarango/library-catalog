<?php include_once('app/admin/snippets/admin_header.php'); ?>

<?php

ob_start();
if (isset($_GET['isbn'])) {
      $isbn = htmlspecialchars($_GET['isbn']);

      // Google Books API endpoint
      $api_url = "https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn";

      // Use cURL to fetch data
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $api_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($ch);
      curl_close($ch);

      // Decode the JSON response
      $data = json_decode($response, true);

      if (!empty($data['items'][0])) {
            $book = $data['items'][0]['volumeInfo'];

            // Prepare book details
            $book_details = [
                  'title' => $book['title'] ?? 'Unknown',
                  'authors' => implode(', ', $book['authors'] ?? ['Unknown']),
                  'publishedDate' => $book['publishedDate'] ?? 'Unknown',
                  'description' => $book['description'] ?? 'No description available',
                  'thumbnail' => $book['imageLinks']['thumbnail'] ?? ''
            ];

            // Return as JSON
            header('Content-Type: application/json');
            echo json_encode($book_details);
      } else {
            echo json_encode(['error' => 'No book found for this ISBN']);
      }
      exit();
}
?>

<body>
      <h1>Scan ISBN</h1>
      <div id="reader" style="width: 300px;"></div>
      <p id="isbn-output"></p>
      <div id="book-info" style="margin-top: 20px;"></div>

      <script>
            function onScanSuccess(decodedText, decodedResult) {
                  // Assume the scanned code is the ISBN
                  document.getElementById('isbn-output').innerText = `Scanned ISBN: ${decodedText}`;

                  // Send the ISBN to the PHP script
                  fetch(`?isbn=${decodedText}`)
                        .then(response => response.json())
                        .then(data => {
                              const bookInfoDiv = document.getElementById('book-info');
                              if (data.error) {
                                    bookInfoDiv.innerHTML = `<p style="color: red;">Error: ${data.error}</p>`;
                              } else {
                                    bookInfoDiv.innerHTML = `
                            <h2>${data.title}</h2>
                            <p><strong>Authors:</strong> ${data.authors}</p>
                            <p><strong>Published Date:</strong> ${data.publishedDate}</p>
                            <p><strong>Description:</strong> ${data.description}</p>
                            ${
                                data.thumbnail
                                    ? `<img src="${data.thumbnail}" alt="Book Thumbnail" style="max-width: 200px;">`
                                    : ''
                            }
                        `;
                              }
                        })
                        .catch(error => console.error('Error fetching book details:', error));
            }

            function onScanFailure(error) {
                  console.warn(`Code scan error: ${error}`);
            }

            let html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                  fps: 10,
                  qrbox: 250
            });
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
      </script>
</body>

</html>