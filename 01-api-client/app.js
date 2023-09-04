// Une fonction asynchrone retourne une promesse
const fetchData = async () => {
  try {
    const res = await fetch("http://localhost:8000");
    const data = await res.json();
    return data;
  } catch (e) {
    console.error(e);
  }
};

// Ici, on n'attend pas la résolution de la promesse
// On va donc logger la promesse et non son vrai résultat
// Promise{<pending>}
// console.log(fetchData());

// Ici, nous sommes dans un contexte asynchrone
// Nous pouvons donc utiliser le mot-clé "await"
// permettant d'attendre le vrai résultat de la promesse :
// sa résolution
window.onload = async () => {
  console.log(await fetchData());
};
