import {chart} from "./map.js"

import {
    seoPieChart,
    salesPieChart,
    totalGrowthPieChart,
    organicGrowthPieChart,
    brandingPieChart
} from "./pie";

import {
    totalGrowthLinearChart,
    organicGrowthLinearChart,
    projectedEarningsLinearChart
} from "./linear";

import {
    socialsRadarChart
} from "./radar";

import {
    bounceRateBarChart,
    salesBarChart,
} from "./column";

import { sectorComercialArray, countryArray, servicesArray } from "../data";

let selectedCommercialSector = null;
let selectedCountry = null;
let expenses = null;
let roi = null;
let selectedMicroServices = {};
let name = null;
let email = null;
let phone = null;
let company = null;

let brandingPercentage = document.getElementById('pie-percentage');
let organicGrowthPercentage = document.getElementById('organic-growth-pie');
let totalGrowthPercentage = document.getElementById('total-growth-pie');
let seoPercentage = document.getElementById('seo-pie');
let salesPercentage = document.getElementById('sales-percentage');
let projectedEarningsMoney = document.getElementById('projected-earnings-money');


let dashboard = document.getElementById('dashboard');
let form = document.getElementById('form');
let signupForm = document.getElementById('sign-up-container');

let testSector = document.getElementById('test-sector');
let testCountry = document.getElementById('test-country');
let testExpenses = document.getElementById('test-expenses');
let testRoi = document.getElementById('test-roi');

let errorMessage = document.getElementById('error-message');
let errorMessageSignup = document.getElementById('error-message-signup');

let thankYouMessage = document.getElementById('thank-you');

let sectorButton = document.getElementById('sector');
let sectorContainer = document.getElementById('sector-container');

let serviceValueButton = document.getElementById('service-value');
let serviceValueContainer = document.getElementById('service-value-container');

let countryButton = document.getElementById('country');
let countryContainer = document.getElementById('country-container');

let serviceButton = document.getElementById('services');
let serviceContainer = document.getElementById('services-container');

let expensesInput = document.getElementById('expenses-input');
let roiInput = document.getElementById('roi-input');

let emailInput = document.getElementById('email-input');
let nameInput = document.getElementById('name-input');
let phoneInput = document.getElementById('phone-input');
let companyInput = document.getElementById('company-input');

let submitButton = document.getElementById('submit-button');
let signupButton = document.getElementById('submit-signup-button');

let resetButton = document.getElementById('reset-form');
function toggleActiveClass(element, className) {
    let buttonsContainer = document.getElementsByClassName(className);
    for (let i = 0; i < buttonsContainer.length; i++) {
        // buttonsContainer[i].classList.remove('active');
        if(buttonsContainer[i] === element){
            element.classList.contains('active') ? element.classList.remove('active') : element.classList.add('active');
        } else {
            buttonsContainer[i].classList.remove('active');
        }
    }

}

function toggleVisibleClass(element, className = 'content') {
    let containers = document.getElementsByClassName(className);
    for (let i = 0; i < containers.length; i++) {
        if(containers[i] === element){
            if(element.classList.contains('visible')) {
                    element.classList.add('hidden')
                    element.classList.remove('visible')
                } else {
                    element.classList.remove('hidden')
                    element.classList.add('visible')
                }
        } else {
            containers[i].classList.add('hidden');
            containers[i].classList.remove('visible');
            // element.classList.remove('visible');
        }
    }
    // element.classList.add('visible');
    // element.classList.remove('hidden');

}

function generateOptions(data, context, target){
    for (let i = 0; i < data.length; i++) {
        let button = document.createElement('button');
        button.classList.add(`detailed-${context}-button`);
        let buttonId = context === 'service' ? data[i].toLowerCase().split(' ').join('-') : data[i].id;
        button.id = buttonId;
        let buttonName = context === 'service' ? data[i] : data[i].name;
        button.innerHTML = buttonName;
        button.addEventListener('click', function () {
            // finalVariable = button.id;
            if(context==='country'){
                selectedCountry === button.id ? selectedCountry = null : selectedCountry = button.id;
            }
            if(context==='sector'){
                selectedCommercialSector === button.id ? selectedCommercialSector = null : selectedCommercialSector = button.id;
            }
            // if(context==='service'){
            //     if(selectedMicroServices.includes(buttonId)) {
            //         selectedMicroServices = selectedMicroServices.filter(microService => microService !== buttonId)
            //     } else {
            //         selectedMicroServices.push(buttonId)
            //     }
            // }
            toggleActiveClass(button, `detailed-${context}-button`);
        });
        target.appendChild(button);
    }
}

function generateServices(data, context, target){
    for(let i = 0; i < data.length; i++) {
        let serviceId = data[i].service.toLowerCase().split(' ').join('-');
        let specificServiceButton = document.createElement('button');
        specificServiceButton.classList.add('sub-service-container')
        specificServiceButton.id = serviceId;
        specificServiceButton.innerHTML = data[i].service;
        let specificServiceContainer = document.createElement('div');
        specificServiceContainer.classList.add(`sub-service-content`, 'hidden');
        // generateOptions(data[i].subServices, context, specificServiceContainer, null)
        for(let j = 0; j < data[i].subServices.length; j++){
            let microServiceId = data[i].subServices[j].toLowerCase().split(' ').join('-');
            let microServiceName = data[i].subServices[j];
            let button = document.createElement('button');
            button.classList.add(`detailed-${serviceId}-button`);
            button.id = microServiceId;
            button.innerHTML = microServiceName;
            button.addEventListener('click', function (){
                if(selectedMicroServices[serviceId] && selectedMicroServices[serviceId].includes(microServiceId)) {
                    selectedMicroServices[serviceId] = selectedMicroServices[serviceId].filter(microService => microService !== microServiceId)
                } else {
                    if(!selectedMicroServices[serviceId]) {
                        selectedMicroServices[serviceId] = [microServiceId]
                    }
                    else {
                        selectedMicroServices[serviceId.split('-').join('')].push(microServiceId.split('-').join(''))
                    }
                }
                let buttonsContainer = document.getElementsByClassName(`detailed-${serviceId}-button`);
                for(let k = 0; k < buttonsContainer.length; k++){
                    if(buttonsContainer[k]===button){
                        button.classList.contains('active') ? button.classList.remove('active') : button.classList.add('active')
                    }
                }
            })
            specificServiceContainer.appendChild(button);
        }
        specificServiceButton.addEventListener('click', function () {
            toggleActiveClass(specificServiceButton, 'sub-service-container');
            toggleVisibleClass(specificServiceContainer, `sub-service-content`);
        });
        target.appendChild(specificServiceButton);
        target.appendChild(specificServiceContainer);
    }
}

function addListenersToButtons(button, container) {
    button.addEventListener('click', function () {
        toggleActiveClass(button, 'form-button');
        toggleVisibleClass(container);
    });
}

function addListenersToInputs(input, finalVariable) {
    input.addEventListener('input', function () {
        finalVariable = input.value;
    });
}

resetButton.addEventListener('click', function () {
    let visibleElements = document.getElementsByClassName('content');
    let activeElements = document.getElementsByClassName('active');

    let visibleSubServices = document.getElementsByClassName('sub-service-content');
    let activeServices = document.getElementsByClassName('sub-service-container');

    for(let i = 0; i < visibleElements.length; i++) {
        // console.log(visibleElements[i])
        if(visibleElements[i].classList.contains('hidden') === false) {
            visibleElements[i].classList.add('hidden')
            visibleElements[i].classList.remove('visible');
        }
    }

    for(let i = 0; i < visibleSubServices.length; i++) {
        if(visibleSubServices[i].classList.contains('hidden') === false) {
            visibleSubServices[i].classList.add('hidden')
            visibleSubServices[i].classList.remove('visible');
        }
        let buttons = visibleSubServices[i].getElementsByTagName('button')
        for(let j = 0; j < buttons.length; j++){
            buttons[j].classList.remove('active');
        }
    }

    for (let i = 0; i < activeElements.length; i++) {
        // console.log(activeElements[i])
        activeElements[i].classList.remove('active');
    }

    for (let i = 0; i < activeServices.length; i++) {
        // console.log(activeServices[i])
        activeServices[i].classList.remove('active');
    }

    expensesInput.value = null;
    roiInput.value = null;
    nameInput.value = null;
    emailInput.value = null;
    selectedCountry = null;
    selectedCommercialSector = null;
    selectedMicroServices = {};
    roi = null;
    expenses = null;
    name = null;
    email = null;

    dashboard.classList.add('d-hidden');
    form.classList.add('f-visible');
    dashboard.classList.remove('d-visible');
    form.classList.remove('f-hidden');

    signupForm.classList.add('su-hidden');
    signupForm.classList.remove('su-visible');
    thankYouMessage.classList.add('t-hidden');
    thankYouMessage.classList.remove('t-visible')
})

signupButton.addEventListener('click', function (){
    name = nameInput.value;
    email = emailInput.value;
    phone = phoneInput.value;
    company = companyInput.value;

    if(name === null || name === '' || email === null || email === '') {
        errorMessageSignup.innerHTML = 'Missing fields';
    } else {
        fetch('index.php?option=com_ajax&plugin=pluginMicroservicios&format=json', {
            method: 'POST',
            body: {
                name,
                email,
                phone,
                company,
                tipo: 'guardarDatos'
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
            .then(response => {
                errorMessageSignup.innerHTML = '';
                signupForm.classList.add('su-hidden');
                signupForm.classList.remove('su-visible');
                thankYouMessage.classList.add('t-visible');
                thankYouMessage.classList.remove('t-hidden')
            })
            .catch(err => {
                console.log(err)
                alert(err.message);
            });

    }

})
submitButton.addEventListener('click', function () {

    let actives = document.getElementsByClassName('active');
    for (let i = 0; i < actives.length; i++) {
        if(actives[i].classList.contains('detailed-sector-button')){
            selectedCommercialSector = actives[i].id;
        }
        if(actives[i].classList.contains('detailed-country-button')){
            selectedCountry = actives[i].id;
        }
    }

    expenses = expensesInput.value;
    roi = roiInput.value;
    if(selectedCommercialSector === null || selectedCountry === null || expenses === null || expenses === '' || roi === null || roi === '' || Object.keys(selectedMicroServices).length === 0) {
        errorMessage.innerHTML = 'Missing fields';
    } else {

        console.log('microservicios: ', selectedMicroServices);

        console.log('sector', selectedCommercialSector);

        const formData = new FormData();
        formData.append('microServices', JSON.stringify(selectedMicroServices));
        formData.append('sector-comercial', selectedCommercialSector);
        formData.append('country', selectedCountry);
        formData.append('expenses', expenses);
        formData.append('roi', roi);
        formData.append('tipo', 'userForm');

        fetch('index.php?option=com_ajax&plugin=pluginMicroservicios&format=json', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                let dataMicroservices = data.data && JSON.parse(data.data[0]);

                console.log(dataMicroservices);
                branding = dataMicroservices[0].branding;
                brandingPercentage.innerHTML = `${branding}%`;
                organicGrowth = dataMicroservices[0].organicGrowth;
                organicGrowthPercentage.innerHTML = `${organicGrowth}%`;
                totalGrowth = dataMicroservices[0].totalGrowth;
                totalGrowthPercentage.innerHTML = `${totalGrowth}%`;
                seoLevel = dataMicroservices[0].seoLevel;
                seoPercentage.innerHTML = `${seoLevel}%`;
                countriesList = dataMicroservices[0].country;
                sales = data.sales;
                salesPercentage.innerHTML = `${data.sales}%`;
                projectedEarnings =  dataMicroservices[0].projectedEarnings;
                projectedEarningsMoney.innerHTML = `${projectedEarnings}%`;

                errorMessage.innerHTML = '';
                dashboard.classList.add('d-visible');
                dashboard.classList.remove('d-hidden');
                form.classList.add('f-hidden')
                form.classList.remove('f-visible');
                signupForm.classList.add('su-visible')
                signupForm.classList.remove('su-hidden')
            })
            .catch(err => {
                console.log(err)
                alert(err.message);

            });
        // testSector.innerHTML = selectedCommercialSector;
        // testCountry.innerHTML = selectedCountry;
        // testExpenses.innerHTML = expenses;
        // testRoi.innerHTML = roi;
    }
});

generateOptions(sectorComercialArray, 'sector', sectorContainer, selectedCommercialSector);
generateOptions(countryArray, 'country', countryContainer, selectedCountry);

generateServices(servicesArray, 'service', serviceContainer);

addListenersToButtons(sectorButton, sectorContainer);
addListenersToButtons(countryButton, countryContainer);
addListenersToButtons(serviceValueButton, serviceValueContainer);
addListenersToButtons(serviceButton, serviceContainer);

addListenersToInputs(expensesInput, expenses);
addListenersToInputs(roiInput, roi);