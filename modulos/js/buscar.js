(() => {
  const btnBuscar = document.getElementById("btnBuscar");
  const resultadosDiv = document.getElementById("resultadosBusqueda");

  if (!btnBuscar || !resultadosDiv) {
    console.log("⚠️ Elementos de búsqueda no encontrados, abortando buscar.js");
    return; // No hacemos nada si los elementos no están
  }

  btnBuscar.addEventListener("click", () => {
    const modulo = document.getElementById("selectModulo").value;
    const termino = document.getElementById("inputBusqueda").value.trim();

    if (!termino) {
      resultadosDiv.innerHTML = '<div class="alert alert-warning">Por favor, escribí un término para buscar.</div>';
      return;
    }

    resultadosDiv.innerHTML = '<div class="text-center">Buscando...</div>';

    fetch(`modulos/controllers/busqueda_global.php?modulo=${modulo}&termino=${encodeURIComponent(termino)}&_=${Date.now()}`)
      .then(response => {
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return response.text();
      })
      .then(html => {
        resultadosDiv.innerHTML = html;
      })
      .catch(error => {
        resultadosDiv.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
        console.error('Error en fetch:', error);
      });
  });
})();
