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
let selectedMicroServices = [];

let testSector = document.getElementById('test-sector');
let testCountry = document.getElementById('test-country');
let testExpenses = document.getElementById('test-expenses');
let testRoi = document.getElementById('test-roi');
let errorMessage = document.getElementById('error-message');

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

let submitButton = document.getElementById('submit-button');

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
                selectedCommercialSector === button.id ? selectedCommercialSector = null : selectedCountry = button.id;
            }
            if(context==='service'){
                if(selectedMicroServices.includes(buttonId)) {
                    selectedMicroServices = selectedMicroServices.filter(microService => microService !== buttonId)
                } else {
                    selectedMicroServices.push(buttonId)
                }
            }
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
                if(selectedMicroServices.includes(microServiceId)) {
                    selectedMicroServices = selectedMicroServices.filter(microService => microService !== microServiceId)
                } else {
                    selectedMicroServices.push(microServiceId)
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
            // let containers = document.getElementsByClassName(`sub-service-content`);
            // console.log(containers)
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
    if(selectedCommercialSector === null || selectedCountry === null || expenses === null || roi === null){
        errorMessage.innerHTML = 'Missing fields';
        testSector.innerHTML = '';
        testCountry.innerHTML = '';
        testExpenses.innerHTML = '';
        testRoi.innerHTML = '';
    } else {
        console.log(selectedMicroServices)
        testSector.innerHTML = selectedCommercialSector;
        testCountry.innerHTML = selectedCountry;
        testExpenses.innerHTML = expenses;
        testRoi.innerHTML = roi;
        errorMessage.innerHTML = '';
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