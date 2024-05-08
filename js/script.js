document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('search-form');

    searchForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting in the traditional way
        searchBooks(); 
    });
});

function searchBooks() {
    const searchQuery = document.getElementById('search-input').value;

    // here, the PHP script is called via the fetch API
    fetch('php/search.php?term=' + encodeURIComponent(searchQuery))
        .then(response => response.json())
        .then(data => {
            const resultsContainer = document.getElementById('search-results'); 
            resultsContainer.innerHTML = ''; // Clear previous results

            // Check if any data returned
            if (data && data.length === 0) {
                resultsContainer.innerHTML = '<p>No books found.</p>';
                return;
            }

            // Dynamically create the list of search results
            // Inside the searchBooks function, update the forEach loop
            data.forEach(book => {
                const bookElement = document.createElement('div');
                bookElement.className = 'book-result';
                bookElement.innerHTML = `
                    <span>${book.title} by ${book.author}</span>
                    <button onclick="addFavorite(${book.id})">Add to Favorites</button>`;
                resultsContainer.appendChild(bookElement);
            });

        })
        .catch(error => {
            console.error('Error:', error);
            resultsContainer.innerHTML = '<p>An error occurred while searching.</p>';
        });
}

function addFavorite(bookId) {
    fetch('php/add_favorite.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `bookId=${bookId}`,
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Alert the user that the book has been added to favorites 
    })
    .catch(error => console.error('Error:', error));
}
