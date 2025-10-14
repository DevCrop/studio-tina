/**
 * Spiral Gallery Fetch
 * API에서 데이터를 가져와 spiral-gallery에 렌더링
 */

async function loadSpiralGallery() {
  const container = document.getElementById("spiral-gallery-container");
  if (!container) return;

  try {
    const response = await fetch("/api/spiral-gallery.php?limit=8");
    const data = await response.json();

    if (data.success && data.data.length > 0) {
      renderSpiralGallery(data.data);
    } else {
      container.innerHTML = '<p class="no-data">No works available</p>';
    }
  } catch (error) {
    console.error("Spiral Gallery Error:", error);
    container.innerHTML = '<p class="error">Failed to load gallery</p>';
  }
}

function renderSpiralGallery(works) {
  const container = document.getElementById("spiral-gallery-container");

  const html = works
    .map(
      (work) => `
    <div class="item">
      <a href="${work.link_url}">
        <img src="${work.image_url}" alt="${work.title || "Work"}">
        <div class="item-info">
          <h3>${work.title || "Untitled"}</h3>
        </div>
      </a>
    </div>
  `
    )
    .join("");

  container.innerHTML = html;

  // Spiral Gallery 초기화 (기존 스크립트가 있다면)
  if (typeof initSpiralGallery === "function") {
    initSpiralGallery();
  }
}

// DOM 로드 시 실행
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", loadSpiralGallery);
} else {
  loadSpiralGallery();
}
