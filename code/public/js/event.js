'use strict';

const btnEvent = document.getElementById(`btn-event`);
const btnDropEvent = document.getElementById(`btn-drop-events`);
const eventsList = document.querySelector(`.event-list`);
const inputParam1 = document.getElementById(`inputParam1`);
const inputParam2 = document.getElementById(`inputParam2`);
const eventForm = document.getElementById(`form-new-event`);
const flushElement = document.querySelector(`.alert`);
const generateEventElement = document.querySelector(`.generate-event`);


const loadEvents = async () => {
    const headers = new Headers();
    headers.append("Content-Type", "application/json");
    const requestOptions = {
        method: 'GET',
        headers,
    };

    const response = await fetch(`/api/events`, requestOptions);
    const data = await response.json();
    if (response.status === 200) {
        if (data.length !== 0) {
            eventsList.innerHTML = data.map((item) => createEventListItem(item)).join(``);
            removeHidden();
        }

    }
}
const handleNewEventSubmit = async (evt) => {
    evt.preventDefault();

    const response = await fetch('/api/events', {
        method: 'POST',
        body: new FormData(eventForm),
    });

    const data = await response.json();
    if (response.status === 201) {
        eventsList.insertAdjacentHTML(`afterbegin`, createEventListItem(data));
        btnDropEvent.classList.remove(`visually-hidden`);
        generateEventElement.classList.remove(`visually-hidden`);
        eventForm.reset();
        clearFlush();
    } else {
        showError(data['error']);
    }
}
const handleEventClick = async (evt) => {
    evt.preventDefault();

    const headers = new Headers();
    headers.append("Content-Type", "application/json");
    const params = {"params": {"param1": inputParam1.value, "param2": inputParam2.value}};
    const requestOptions = {
        method: 'POST',
        headers,
        body: JSON.stringify(params),
        redirect: 'follow'
    };

    try {
        const response = await fetch("/api/event", requestOptions);
        const data = await response.json();
        if (response.status === 400) {
            showError(data['error'])
        } else {
            showEvent(data);
        }

    } catch (err) {
        console.log(err);
    }
}
const handleDropClick = async (evt) => {
    const headers = new Headers();
    headers.append("Content-Type", "application/json");
    const requestOptions = {
        method: `DELETE`,
        headers,
    };

    const response = await fetch(`/api/events`, requestOptions);
    const data = await response.json();
    if (data[`status`] === 'OK') {
        eventsList.innerHTML = ``;
        showSuccess(`Events deleted`);
    }
}

document.addEventListener(`DOMContentLoaded`, loadEvents);
if (btnEvent) {
    btnEvent.addEventListener(`click`, handleEventClick);
}
if (btnDropEvent) {
    btnDropEvent.addEventListener(`click`, handleDropClick);
}
eventForm.addEventListener(`submit`, handleNewEventSubmit);

const showEvent = (data) => {
    let params = data['param1'] ? `param1=${data['param1']} ` : ``;
    params += data['param2'] ? `param2=${data['param2']}` : ``;
    const html = `<h5>Event: ${data['event']}</h5>
        <p class="card-text">Priority: ${data['priority']} Condition: ${params}</p>`;

    flushElement.classList.remove(`alert-danger`);
    flushElement.classList.add(`alert-success`);
    flushElement.innerHTML = html;
}
const showError = (error) => {
    flushElement.classList.remove(`alert-success`);
    flushElement.classList.add(`alert-danger`);
    flushElement.innerHTML = `<p class="card-text">${error}</p>`;
}
const showSuccess = (message) => {
    flushElement.classList.add(`alert-success`);
    flushElement.classList.remove(`alert-danger`);
    flushElement.innerHTML = `<p class="card-text">${message}</p>`;
}
const clearFlush = () => {
    flushElement.innerHTML = ``;
    flushElement.classList.remove(`alert-danger`);
    flushElement.classList.remove(`alert-success`);
}
const createEventListItem = (item) => {
    let cond = item[`param1`] ? `param1=${item[`param1`]} ` : ``;
    cond += item[`param2`] ? `param2=${item[`param2`]}` : ``;
    return `<li class="list-group-item">
                <h5 class="card-title">Event: ${item[`event`]}</h5>
                <p class="card-text">
                Priority: ${item[`priority`]}
                Condition: ${cond}
                </p>
             </li>`
};
const removeHidden = () => {
    btnDropEvent.classList.remove(`visually-hidden`);
    generateEventElement.classList.remove(`visually-hidden`);
}
