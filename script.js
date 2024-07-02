document.addEventListener('DOMContentLoaded', function() {
    const oyunlarContainer = document.querySelector('.oyunlar');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const pageInfo = document.getElementById('page-info');
    const itemsPerPage = 15;
    let currentPage = 1;
    let totalItems = 0;

    function fetchOyunlar(page) {
        fetch(`fetch_games.php?page=${page}&items_per_page=${itemsPerPage}`)
            .then(response => response.json())
            .then(data => {
                totalItems = data.totalItems;
                renderOyunlar(data.items);
                updatePagination();
            });
    }

    function renderOyunlar(oyunlar) {
        oyunlarContainer.innerHTML = '';
        oyunlar.forEach(oyun => {
            const oyunDiv = document.createElement('div');
            oyunDiv.classList.add('oyun');
            oyunDiv.innerHTML = `
                <img src="${oyun.resim_url}" alt="${oyun.baslik}">
                <div class="info">
                    <h2>${oyun.baslik}</h2>
                    <p>${oyun.detayli_aciklama}</p>
                    <button onclick="location.href='detay.php?id=${oyun.id}'">Oyunu İncele</button>
                </div>
            `;
            oyunlarContainer.appendChild(oyunDiv);
        });
    }

    function updatePagination() {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        pageInfo.textContent = `Sayfa ${currentPage} / ${totalPages}`;
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
    }

    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            fetchOyunlar(currentPage);
        }
    });

    nextBtn.addEventListener('click', () => {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            fetchOyunlar(currentPage);
        }
    });

    fetchOyunlar(currentPage);
});
