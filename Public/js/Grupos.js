document.getElementById('tipoGrupo').addEventListener('change', function() {
    const tipoGrupo = this.value;
    cargarComentarios(tipoGrupo);
});

document.getElementById('commentForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const tipoGrupo = document.getElementById('tipoGrupo').value;
    const comentario = document.getElementById('comentario').value;
    agregarComentario(tipoGrupo, comentario);
});

function cargarComentarios(tipoGrupo) {
    fetch(`http://localhost/Habitos/api-rest/api/consultar_comentarios_por_grupo.php?grupo_id=${tipoGrupo}`)
        .then(response => response.json())
        .then(data => {
            const comentariosContainer = document.getElementById('comentariosGrupo');
            comentariosContainer.innerHTML = ''; // Limpiar comentarios anteriores
            if (data.status === 'success') {
                data.data.forEach(comentario => {
                    const comentarioHTML = `
                        <div class="comentario">
                            <p><strong>Usuario Anonimo</strong> - ${comentario.fecha_comentario}</p>
                            <p>${comentario.comentario}</p>
                        </div>
                    `;
                    comentariosContainer.innerHTML += comentarioHTML;
                });
            }
        })
        .catch(error => console.error('Error al cargar comentarios:', error));
}

function agregarComentario(grupoId, comentario) {
    const usuarioId = 1; // Reemplaza con el ID del usuario actual
    const fechaComentario = new Date().toISOString().split('T')[0]; // Fecha actual en formato YYYY-MM-DD

    fetch('http://localhost/Habitos/api-rest/api/crear_comentario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            grupo_id: grupoId,
            usuario_id: usuarioId,
            comentario: comentario,
            fecha_comentario: fechaComentario
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Comentario agregado exitosamente!');
            cargarComentarios(grupoId); // Recargar comentarios
            document.getElementById('comentario').value = ''; // Limpiar el campo de texto
        } else {
            alert('Error al agregar comentario: ' + data.message);
        }
    })
    .catch(error => console.error('Error al agregar comentario:', error));
}