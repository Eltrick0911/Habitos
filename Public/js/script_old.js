$(document).ready(function() {
    // Cargar nombre del usuario
    const nombreCompleto = sessionStorage.getItem('nombre_completo');
    if (nombreCompleto) {
        $('.profile select').html(`<option value="${nombreCompleto}">${nombreCompleto}</option>`);
    }

    // Función para cargar hábitos desde el servidor
    function cargarHabitos() {
        $.ajax({
            url: 'http://localhost/Habitos/api-rest/api/consultar_habito.php',
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    const habitosContainer = $('.upcoming-appointments .card-body');
                    habitosContainer.empty();

                    response.data.forEach(habito => {
                        const habitoHTML = `
                            <div class="appointment">
                                <span class="name">${habito.nombre_habito}</span>
                                <span class="title">${habito.descripcion_habito}</span>
                                <span class="date">
                                    <i class="fa fa-calendar" aria-hidden="true"></i> ${habito.fecha_inicio}
                                </span>
                                <span class="time">
                                    <i class="fas fa-clock"></i> ${habito.duracion_estimada}
                                    <br><small>(${habito.frecuencia})</small>
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
                    console.error('Error al cargar hábitos:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar hábitos:', error);
            }
        });
    }

    // Mantener el código existente
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
                    cargarHabitos(); // Cargar hábitos después de recargar el index
                } else {
                    $("#contenidoDinamico").html(response);
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
            labels: ["", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", ""],
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

    // Cargar hábitos al iniciar la página
    cargarHabitos();
});