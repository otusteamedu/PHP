'use strict';

const HIDDEN_STYLE = `visually-hidden`;

const rootElement = document.querySelector('div.col');
const selectElement = rootElement.querySelector('select[name=type_val]');
const inputElements = rootElement.querySelectorAll('input');

const hideElements = async (number) => {
  for (const element of inputElements) {
    if (element.name.includes(number)) {
      element.parentElement.classList.remove(HIDDEN_STYLE);
    } else {
      element.parentElement.classList.add(HIDDEN_STYLE);
    }
  }
};

const selectClickHandler = async () => {
  const number = selectElement.value;
  await hideElements(number);
};


document.addEventListener('click', selectClickHandler);
