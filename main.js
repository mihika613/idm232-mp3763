// Recipe info (same for all cards)
const recipe = {
    image: "images/0101_2PM_Steak-Diane_97315_SQ_hi_res copy.jpg",
    category: "Category",
    name: "Name of Recipe",
    subtitle: "Subtitle",
    time: "Time",
    calories: "# Cal"
  };
  
  // Select the container
  const recipeContainer = document.getElementById("recipeContainer");
  
  // Loop 5 times to create identical cards
  for (let i = 0; i < 10; i++) {
    const card = document.createElement("div");
    card.classList.add("recipe-card");
  
    card.innerHTML = `
      <img alt="${recipe.name}" src="${recipe.image}">
      <h6>${recipe.category}</h6>
      <h3>${recipe.name}</h3>
      <h4>${recipe.subtitle}</h4>
      <div class="in-line">
        <h6>⏱ ${recipe.time}</h6>
        <h6>${recipe.calories}</h6>
      </div>
    `;
  
    // Make each card clickable
    card.addEventListener("click", () => {
      window.location.href = "recipe.html";
    });
  
    recipeContainer.appendChild(card);
  }


  document.getElementById("helpBtn").addEventListener("click", () => {
    window.location.href = "help.html";
  });