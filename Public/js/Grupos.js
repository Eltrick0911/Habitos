document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('jwt_token');
    if (!token) {
        alert('Debe iniciar sesión para acceder a los grupos');
        window.location.href = '/Habitos/Public/Index.html';
        return;
    }
});

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
    fetch(`http://localhost/Habitos/api-rest/api/consultar_comentarios_por_grupo.php?grupo_id=${tipoGrupo}`, {
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
        }
    })
    .then(response => response.json())
    .then(data => {
        const comentariosContainer = document.getElementById('comentariosGrupo');
        comentariosContainer.innerHTML = '';
        if (data.status === 'success') {
            data.data.forEach(comentario => {
                const comentarioHTML = `
                    <div class="comentario">
                        <p><strong>${comentario.nombre_usuario || 'Usuario Anónimo'}</strong> - ${comentario.fecha_comentario}</p>
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
    const usuarioId = localStorage.getItem('usuario_id');
    const fechaComentario = new Date().toISOString().split('T')[0];

    fetch('http://localhost/Habitos/api-rest/api/crear_comentario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
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
            cargarComentarios(grupoId);
            document.getElementById('comentario').value = '';
        } else {
            alert('Error al agregar comentario: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al agregar comentario:', error);
        alert('Error al agregar el comentario. Por favor, intente nuevamente.');
    });
}