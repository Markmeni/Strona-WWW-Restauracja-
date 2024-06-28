document.addEventListener("DOMContentLoaded", function() {
    function loadReviews(menuId) {
        fetch(`get_reviews.php?menu_id=${menuId}`)
            .then(response => response.json())
            .then(data => {
                const reviewsContainer = document.getElementById(`reviews-${menuId}`);
                reviewsContainer.innerHTML = data.reviews.map(review => `
                    <div class="review">
                        <p><strong>${review.username}:</strong> ${review.comment} (Rating: ${review.rating}/5)</p>
                        ${review.response ? `<p><strong>Admin Response:</strong> ${review.response}</p>` : ""}
                    </div>
                `).join('') || "<p>No reviews yet.</p>";
            });
    }

    document.querySelectorAll(".review-form").forEach(function(form) {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch("submit_review.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                const responseMessage = document.createElement("p");
                responseMessage.textContent = data;
                responseMessage.style.color = "green";
                this.appendChild(responseMessage);
                this.reset();
                const menuId = this.querySelector('input[name="menu_id"]').value;
                loadReviews(menuId);
            });
        });
    });

    if (document.getElementById("reservation-form")) {
        document.getElementById("reservation-form").addEventListener("submit", function(e) {
            e.preventDefault(); 

            const formData = new FormData(this);
            fetch("make_reservation.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                const responseMessage = document.getElementById("response-message");
                responseMessage.textContent = data;
                responseMessage.style.display = "block";
                document.getElementById("reservation-form").reset();
            });
        });
    }

});
function filterMenu(categoryId) {
    const menuItems = document.querySelectorAll(".menu-item");
    menuItems.forEach(function(item) {
        if (categoryId === 'all' || item.getAttribute("data-category") === categoryId) {
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    });
}