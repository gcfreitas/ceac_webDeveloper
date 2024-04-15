let selectCategoria = document.getElementById('lcat_id');

selectCategoria.onchange = () => {
	let selectGenero = document.getElementById('lgen_id');
	let valor = selectCategoria.value;
	
	fetch("genero_select.php?lcat_id=" + valor)
		.then(response => {
			return response.text();
		})
		.then(gen_op => {
			selectGenero.innerHTML = gen_op;
		});
}