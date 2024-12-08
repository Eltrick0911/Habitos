$(document).ready(function() {
    // Cargar nombre del usuario
    const nombreCompleto = sessionStorage.getItem('nombre_completo');
    const usuario_id = sessionStorage.getItem('usuario_id');
    
    console.log('Datos de sesión:', {
        nombreCompleto,
        usuario_id
    });

    if (nombreCompleto) {
        $('.profile select').html(`<option value="${nombreCompleto}">${nombreCompleto}</option>`);
    }

    // Función para cargar hábitos desde el servidor
    function cargarHabitos() {
        const usuario_id = sessionStorage.getItem('usuario_id');
        
        if (!usuario_id) {
            console.error('No se encontró ID de usuario');
            return;
        }

        $.ajax({
            url: `http://localhost/Habitos/api-rest/api/consultar_habito.php?usuario_id=${usuario_id}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                try {
                    if (response.status === 'success') {
                        const habitosContainer = $('.upcoming-appointments .card-body');
                        habitosContainer.empty();

                        if (response.data && response.data.length > 0) {
                            // Limitar a los primeros 3 hábitos
                            response.data.slice(0, 3).forEach(habito => {
                                const habitoHTML = `
                                    <div class="appointment">
                                        <span class="name">${habito.nombre_habito}</span>
                                        <span class="title">${habito.descripcion_habito}</span>
                                        <span class="date">
                                            <i class="fa fa-calendar" aria-hidden="true"></i> ${habito.fecha_inicio}
                                        </span>
                                        <span class="time">
                                            <i class="fas fa-clock"></i> ${habito.duracion_estimada}
                                            ${habito.frecuencia ? `<br><small>(${habito.frecuencia})</small>` : ''}
                                        </span>
                                        <a href="#" class="check" data-id="${habito.id_habito}">
                                            <i class="far fa-check-circle" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" class="times" data-id="${habito.id_habito}">
                                            <i class="far fa-times-circle" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                `;
                                habitosContainer.append(habitoHTML);
                            });
                        } else {
                            habitosContainer.html('<p>No hay hábitos registrados.</p>');
                        }
                    } else {
                        console.error('Error en la respuesta:', response.message);
                    }
                } catch (e) {
                    console.error('Error al procesar la respuesta:', e);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar hábitos:', {
                    error: error,
                    status: status,
                    response: xhr.responseText
                });
            }
        });
    }

    $(".btn-appointment").click(function() {
        cargarContenido("../../Routes/views/AgregarHabito.html");
    });

    $(".aside ul li").click(function(event) {
        event.stopPropagation();
        var indice = $(this).index();

        switch (indice) {
            case 0:
                cargarContenido("../views/index.html");
                break;
            case 1:
                break;
            case 2:
                cargarContenido("../views/GrupoApoyo.html");
                break;
            case 3:
                cargarContenido("../views/Habitos.html");
                break;
            default:
                alert("Error al cargar el contenido.");
        }
    });

   function cargarContenido(url) {
    if (window.location.href.endsWith(url)) {
        return;
    }

    $.ajax({
        url: url,
        type: 'GET',
        cache: false,
        success: function(response) {
            if (url === "../views/index.html") {
                $("body").empty();
                $("body").html(response);
                generarGrafico();
                cargarHabitos();
            } else {
                $("#contenidoDinamico").html(response);
                if (url === "../views/Habitos.html") {
                    if (!$('script[src*="habitos.js"]').length) {
                        $.getScript('../../../Public/js/habitos.js');
                    }
                }
            }
        },
        error: function() {
            alert("Error al cargar el contenido.");
        }
    });
}

    // Mantener el código existente del gráfico
    function generarGrafico() {
        var ctx = document.getElementById('recentResultsChart').getContext('2d');
        var gradientFill = ctx.createLinearGradient(0, 0, 0, 200);
        gradientFill.addColorStop(0.1, "rgba(109,110,227, .3)");
        gradientFill.addColorStop(1, "rgba(255,255,255, .3)");
  
        var data = {
            labels: ["", "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", ""],
            datasets: [{
                backgroundColor: "rgba(0,0,0,0)",
                borderColor: "#6d6ee3",
                borderWidth: 2,
                fill: true,
                backgroundColor: gradientFill,
                data: [3, 5, 4, 10, 8, 9, 3, 15, 14, 17],
                pointRadius: 5,
                pointHoverRadius: 7,
                pointColor: "#FFFFFF",
                fillColor: "#FFFFFF",
                strokeColor: "#FF0000",
  
            }]
        };
  
        var options = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            tooltips: {
                mode: 'index',
                intersect: true,
                yPadding: 10,
                xPadding: 10,
                caretSize: 8,
                backgroundColor: '#fff',
                titleFontColor: "#6d6ee3",
                bodyFontStyle: 'bold',
                bodyFontColor: "#737295",
                displayColors: false,
                callbacks: {
                    label: function(tooltipItems, data) {
                        return "10.5";
                    }
                },
                bevelWidth: 3,
                bevelHighlightColor: 'rgba(255, 255, 255, 0.75)',
                bevelShadowColor: 'rgba(0, 0, 0, 0.5)'
            },
            showAllTooltips: true,
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        maxTicksLimit: 5,
                        min: 0,
                    },
                    gridLines: {
                        display: true
                    }
                }],
                xAxes: [{
                    display: true,
                    ticks: {
                        fontSize: 12,
                        fontColor: '#c3c6de'
                    },
                    gridLines: {
                        display: false
                    }
                }]
            },
            elements: {
                point: {
                    radius: 0
                }
            }
        };
  
        Chart.pluginService.register({
            beforeRender: function(chart) {
                if (chart.config.options.showAllTooltips) {
                    chart.pluginTooltips = [];
                    chart.config.data.datasets.forEach(function(dataset, i) {
                        chart.getDatasetMeta(i).data.forEach(function(sector, j) {
                            chart.pluginTooltips.push(new Chart.Tooltip({
                                _chart: chart.chart,
                                _chartInstance: chart,
                                _data: chart.data,
                                _options: chart.options.tooltips,
                                _active: [sector]
                            }, chart));
                        });
                    });
  
                    chart.options.tooltips.enabled = false;
                }
            },
            afterDraw: function(chart, easing) {
                if (chart.config.options.showAllTooltips) {
                    if (!chart.allTooltipsOnce) {
                        if (easing !== 1)
                            return;
                        chart.allTooltipsOnce = true;
                    }
  
                    chart.options.tooltips.enabled = true;
                    Chart.helpers.each(chart.pluginTooltips, function(tooltip, i) {
                        if (i !== 3) return;
                        tooltip.initialize();
                        tooltip.update();
                        tooltip.pivot();
                        tooltip.transition(easing).draw();
                    });
                    chart.options.tooltips.enabled = false;
                }
            }
        });
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });
    }
    $('#logoutButton').click(function() {
        // Limpiar datos de sesión
        sessionStorage.clear();
        // Redirigir a la página de inicio de sesión
        window.location.href = 'http://localhost/Habitos/Public/Index.html';
    });
    // Cargar hábitos al iniciar la página
    cargarHabitos();

    // Lista de consejos en español
    const consejos = [
        "Prioriza una alimentación balanceada.",
        "Haz ejercicio regularmente.",
        "Duerme al menos 8 horas diarias.",
        "Mantén una actitud positiva.",
        "Hidrátate adecuadamente.",
        "Practica la meditación o el yoga.",
        "Establece metas alcanzables.",
        "Dedica tiempo a tus hobbies.",
        "Mantén una buena postura.",
        "Evita el estrés innecesario."
    ];

    // Lista de notificaciones en español
    const notificaciones = [
        "Revisa tu correo para nuevas actualizaciones.",
        "Tu suscripción vence pronto.",
        "Si tienes algun problema con tu cuenta, puedes contactarnos.",
        "Recuerda completar tu perfil.",
        "Revisa constantemente los chats de apoyo.",
        "Eres nuestra prioridad, cuida tu salud mental.",
        "Intentaremos mejorar tu experiencia con nosotros.",
        "Puedes modificar tus habitos en la seccion de habitos.",
        "Recuerda cerrar sesion cuando no estes usando la app.",
        "Gracias por usar nuestra app."
    ];

    // Función para mostrar un consejo aleatorio
    function mostrarConsejoAleatorio() {
        const indiceAleatorio = Math.floor(Math.random() * consejos.length);
        const consejo = consejos[indiceAleatorio];
        const tipsElement = $('.news-list');
        tipsElement.empty(); // Limpiar los tips actuales

        const li = document.createElement('li');
        li.innerHTML = `
            <a href="#" class="news">
                <span class="title">${consejo}</span>
                <i class="fas fa-caret-right"></i>
                <hr />
            </a>
        `;
        tipsElement.append(li);
    }

    // Función para mostrar una notificación aleatoria
    function mostrarNotificacionAleatoria() {
        const indiceAleatorio = Math.floor(Math.random() * notificaciones.length);
        const notificacion = notificaciones[indiceAleatorio];
        const notificationsElement = $('.notifications .card-body ul');
        notificationsElement.empty(); // Limpiar las notificaciones actuales

        const li = document.createElement('li');
        li.innerHTML = `
            <a href="#" class="notification">
                <div class="dot green"></div>
                <span class="title">${notificacion}</span>
                <span class="date">Justo ahora</span>
            </a>
        `;
        notificationsElement.append(li);
    }

    // Llama a las funciones para mostrar un consejo y una notificación al cargar la página
    mostrarConsejoAleatorio();
    mostrarNotificacionAleatoria();
    generarGrafico();

    // Cambia el consejo cada 10 segundos
    setInterval(mostrarConsejoAleatorio, 10000);

    // Cambia la notificación cada 10 minutos
    setInterval(mostrarNotificacionAleatoria, 600000);
});