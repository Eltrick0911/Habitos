

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Healthcare Inicio UI</title>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.4.1/css/all.css'><link rel="stylesheet" href="../../../Public/ccs/style_old.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="wrapper">
        <header class="header">
            <a href="#" class="btn-appointment">Make an appointment</a>
            <div class="profile">
                <div class="image">
                    <img src="https://i.pravatar.cc/150?img=26" />
                    <div class="notification"></div>
                </div>

                <select>
                    <option value="Maria waters">Maria Waters</option>
                </select>
            </div>
        </header>
        <aside class="aside">
            <ul>
                <li class="logo hide">
                    <a href="#"><img src="https://ozcanzaferayan.github.io/healthcare-dashboard/img/logo.png" alt="logo" width="25"></a>
                </li>
                <li class="active"><a href="#"><i class="fas fa-columns"></i></a></li>
                <li><a href="#"><i class="fa fa-folder" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fas fa-chart-area    "></i></a></li>
                <li><a href="#"><i class="fas fa-pills    "></i></a></li>
                <li class="hide"><a href="#"><i class="fas fa-calendar-check    "></i></a></li>
                <li class="hide"><a href="#"><i class="fas fa-file-invoice-dollar    "></i></a></li>
                <li class="hide"><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i>
                    <!-- <span class="count">8</span> -->
                </a></li>
            </ul>
        </aside>
        <main class="main">
            <div class="top">
                <div class="upcoming-appointments card">
                    <div class="card-header">
                        <h1>Mis Habitos</h1>
                        <a href="#"><i class="fa fa-ellipsis-h right" aria-hidden="true"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="appointment">
                            <img class="image" src="https://e7.pngegg.com/pngimages/869/265/png-clipart-drawing-computer-icons-sleep-icon-angle-text.png" />
                            <span class="name">Horas de Sueño</span>
                            <span class="title"></span>
                            <span class="date"><i class="fa fa-calendar" aria-hidden="true"></i> 22/07/2018</span>
                            <span class="time"><i class="fas fa-clock"></i> 11:00 PM</span>
                            <a href="#" class="check"><i class="far fa-check-circle" aria-hidden="true"></i></a>
                            <a href="#" class="times"><i class="far fa-times-circle" aria-hidden="true"></i></a>
                        </div>
                        <div class="appointment">
                            <img class="image gray" src="https://i.pravatar.cc/150?img=1" />
                            <span class="name">dr Caroline Fields</span>
                            <span class="title">psycologist</span>
                            <span class="date"><i class="fa fa-calendar" aria-hidden="true"></i> 22/07/2018</span>
                            <span class="time"><i class="fas fa-clock"></i> 2:30 PM</span>
                            <a href="#" class="check"><i class="fas fa-check-circle" aria-hidden="true"></i></a>
                            <a href="#" class="times"><i class="far fa-times-circle" aria-hidden="true"></i></a>
                        </div>
                        <div class="appointment">
                            <img class="image red" src="https://i.pravatar.cc/150?img=30" />
                            <span class="name">dr Natalie Smith</span>
                            <span class="title">dentist</span>
                            <span class="date"><i class="fa fa-calendar" aria-hidden="true"></i> 22/07/2018</span>
                            <span class="time"><i class="fas fa-clock"></i> 2:30 PM</span>
                            <a href="#" class="check"><i class="far fa-check-circle" aria-hidden="true"></i></a>
                            <a href="#" class="times"><i class="far fa-times-circle" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="recent-results card">
                    <div class="card-header">
                        <div class="header-container">
                            <h1>Recent results </h1>
                            <span>Glucose</span>
                        </div>
                        <select>
                            <option value="May 2018">May 2018</option>
                        </select>
                        <a href="#"><i class="fa fa-ellipsis-h right" aria-hidden="true"></i></a>
                    </div>

                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="recentResultsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="news card">
                    <div class="card-header">
                        <h1>News</h1>
                        <a href="#"><i class="fa fa-ellipsis-h right" aria-hidden="true"></i></a>
                    </div>
                    <div class="card-body">
                        <ul class="news-list">
                            <li>
                                <a href="#" class="news">
                                    <span class="title">10% off for dermatlogist conslutation</span>
                                    <span class="subtitle">Save money for first visit</span>
                                    <i class="fas fa-caret-right"></i>
                                    <hr>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="news">
                                    <span class="title">Free visit to the cardiologist on May 2-6</span>
                                    <span class="subtitle">Take care Of your health, do medical examination</span>
                                    <i class="fas fa-caret-right"></i>
                                    <hr>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="news">
                                    <span class="title">50% discount on allergy tests</span>
                                    <span class="subtitle"> Spring is coming, take control Of allergy</span>
                                    <i class="fas fa-caret-right"></i>
                                    <hr>
                                </a>
                            </li>
                            <li class="more"><a href="#">More...</a></li>
                        </ul>

                    </div>
                </div>
                <div class="current-prescription-container">
                    <div class="current-prescription card">
                        <div class="card-header">
                            <h1>Current prescription </h1>
                            <a href="#"><i class="fa fa-ellipsis-h right" aria-hidden="true"></i></a>
                        </div>
                        <ul>
                            <li>
                                <a href="#" class="prescription-item">
                                    <div class="dot gray"></div>
                                    <span class="title">Vitamin D</span>
                                    <span class="description">5mg - 2x per day</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="prescription-item">
                                    <div class="dot violet"></div>
                                    <span class="title">Cetirizine</span>
                                    <span class="description">10mg - once per day at the morning</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card alert">
                        <div class="card-header">
                            <h1>Alert</h1>
                            <a href="#"><i class="fa fa-ellipsis-h right" aria-hidden="true"></i></a>
                        </div>
                        <span>Air pollution: <b>230%</b> of norm</span>
                    </div>
                </div>
                <div class="notifications card">
                    <div class="card-header">
                        <h1>Notifications </h1>
                        <a href="#"><i class="fa fa-ellipsis-h right" aria-hidden="true"></i></a>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>
                                <a href="#" class="notification">
                                    <div class="dot green"></div>
                                    <span class="title">You confirmed visit to dermatologist</span>
                                    <span class="date">2 days ago</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="notification">
                                    <div class="dot green"></div>
                                    <span class="title">Your results are available to download</span>
                                    <span class="date">3 days ago</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="notification">
                                    <div class="dot green"></div>
                                    <span class="title">Dr. John Smith cancelled your visit</span>
                                    <span class="date">3 days ago</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="notification">
                                    <div class="dot green"></div>
                                    <span class="title">Dr. Ann Doe changed date of your visit</span>
                                    <span class="date">3 days ago</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="notification">
                                    <div class="dot green"></div>
                                    <span class="title">You changed date of appointment</span>
                                    <span class="date">5 days ago</span>
                                </a>
                            </li>
                            <li class="more"><a href="#">More...</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../../../Public/js/script_old.js"></scripts>
<!-- partial -->
  <script src='https://cdn.jsdelivr.net/npm/chart.js@2.8.0'></script>
<script src='https://cdn.jsdelivr.net/npm/chartjs-plugin-deferred@1.0.1'></script>
<script src='https://cdn.jsdelivr.net/npm/chartjs-plugin-style@0.5.0'></script><script  src="./script.js"></script>

</body>
</html>
