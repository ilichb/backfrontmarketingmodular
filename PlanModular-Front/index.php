<?php
    $branding = 35;
    $organic_growth = 18;
    $total_growth = 50;
    $seo_level = 42;
    $sales = 80;
    $projected_earnings = 120000;
    $countries_list = json_encode(array('US', 'CA', 'MX', 'CO', 'ES'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Andromeda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/plugins/system/pluginMicroservicios/PlanModular-Front/styles.css" />
</head>
<body>
    <div class="main">
        <div id="dashboard" class="d-hidden">
            <div class="panel">
                <div class="left-container">
                    <div class="left-top">
                        <div class="branding-organic-growth-container">
                            <div class="branding-container">
                                <p class="branding-container-title">RECONOCMIENTO DE MARCA</p>
                                <div class="branding-chart-container">
                                    <div id="branding-pie"></div>
                                    <p id="pie-percentage" class="pie-percentage"></p>
                                </div>
                            </div>
                            <div class="organic-growth-container">
                                <div class="organic-growth-title-pie-container">
                                    <p class="organic-growth-container-title">CRECIMIENTO ORGANICO</p>
                                    <div class="organic-growth-pie-chart-container">
                                        <div id="organic-growth-pie"></div>
                                        <p id="organic-growth-pie" class="pie-percentage"></p>
                                    </div>
                                </div>
                                <div id="organic-growth-linear"></div>
                            </div>
                        </div>
                        <div class="potential-reach-container">
                            <p class="container-title">ALCANCE POTENCIAL</p>
                            <div id="potential-reach-map"></div>
                        </div>
                    </div>
                    <div class="left-down">
                        <div class="total-growth-seo-container">
                            <div class="total-growth-container">
                                <div class="total-growth-title-pie-container">
                                    <p class="total-growth-container-title">CRECIMIENTO TOTAL</p>
                                    <div class="total-growth-pie-chart-container">
                                        <div id="total-growth-pie"></div>
                                        <p id="total-growth-pie" class="pie-percentage"></p>
                                    </div>
                                </div>
                                <div id="total-growth-linear"></div>
                            </div>
                            <div class="seo-container">
                                <p class="container-title">SEO</p>
                                <div class="seo-pie-chart-container">
                                    <div id="seo-pie"></div>
                                    <p id="seo-pie" class="pie-percentage"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-container">
                    <div class="socials-bounce-container">
                        <div class="socials-container">
                            <p class="container-title">PLATAFORMAS SUGERIDAS</p>
                            <div id="socials-radar"></div>
                        </div>
                        <div class="bounce-container">
                            <p class="container-title">TASA DE REBOTE</p>
                            <div id="bounce-bar"></div>
                        </div>
                    </div>
                    <div class="sales-projected-earnings-container">
                        <div class="sales-container">
                            <p class="container-title">VENTAS 1er TRIMESTRE</p>
                            <div class="sales-pie-chart-container">
                                <div id="sales-pie"></div>
                                <p id="sales-percentage" class="sales-block-percentage"></p>
                            </div>
                            <div id="sales-bar"></div>
                        </div>
                        <div class="projected-earnings-container">
                            <div class="projected-earnings-box">
                                <p class="container-title">GANANCIAS PROYECTADAS</p>
                                <p id="projected-earnings-money" class="projected-earnings-amount"></p>
                            </div>
                            <div id="projected-earnings-linear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <p id="reset-form">reset</p>
        </div>
        <div id="form" class="f-visible">
<!--            <p id="test-sector"></p>-->
<!--            <p id="test-country"></p>-->
<!--            <p id="test-expenses"></p>-->
<!--            <p id="test-roi"></p>-->
            <div class="buttons-container">
                <button id="sector" class="form-button">SECTOR COMERCIAL</button>
                <button id="country" class="form-button">PAIS</button>
                <button id="services" class="form-button">SERVICIOS</button>
                <button id="service-value" class="form-button">VALOR DE SU SERVICIO PRINCIPAL</button>
            </div>
            <div id="sector-container" class="content hidden"></div>
            <div id="country-container" class="content hidden"></div>
            <div id="services-container" class="content hidden"></div>
            <div id="service-value-container" class="content hidden">
                <label for="expenses-input" class="input-label">Gasto presupestario de Marketing ultimo semestre</label>
                <input type="text" id="expenses-input" name="expenses">

                <label for="roi-input" class="input-label">ROI ULTIMO SEMESTRE</label>
                <input type="text" id="roi-input" name="roi">
            </div>
            <div class="submit-button-container">
                <button id="submit-button" class="submit-button">ENVIAR</button>
            </div>
            <p id="error-message"></p>
        </div>
        <div id="signup-form" >
            <div id="sign-up-container" class="su-hidden">
                <label for="name-input" class="input-label">Nombre</label>
                <input type="text" id="name-input" name="name">

                <label for="email-input" class="input-label">Correo</label>
                <input type="text" id="email-input" name="email">

                <label for="phone-input" class="input-label">Telefono</label>
                <input type="text" id="phone-input" name="phone">

                <label for="company-input" class="input-label">Compañia</label>
                <input type="text" id="company-input" name="company">


                <div class="submit-button-container">
                    <button id="submit-signup-button" class="submit-button">ENVIAR</button>
                </div>
            </div>
            <div id="thank-you" class="t-hidden">
                <p>GRACIAS</p>
                <p>Nos comunicaremos contigo muy pronto</p>
            </div>
            <p id="error-message-signup"></p>
        </div>
        <div class="footer">
            <p class="amcharts-credits">Charts provided by <a href="https://www.amcharts.com/">amcharts</a></p>
            <p class="andromeda-credits">© 2023 Andromeda. All rights reserved.</p>
        </div>
    </div>
    <script>
        let branding;
        let organicGrowth;
        let totalGrowth;
        let seoLevel;
        let countriesList = [];
        let sales;
        let projectedEarnings;
    </script>
    <script src="/plugins/system/pluginMicroservicios/PlanModular-Front/bundle.js"></script>
</body>
</html>