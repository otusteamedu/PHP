'use strict';

const IP_API_URL = `http://ip-api.com/json`;

const getVisitorData = async () => {
  const response = await fetch(IP_API_URL);
  const data = await response.json();
  const {query, city} = data;

  return {
    ip: query,
    city,
    device: window.navigator.userAgent,
  };
};

(async () => {
  try {
    const userData = await getVisitorData();
    await loadData(`POST`, userData);
  } catch (err) {
    console.log(err);
  }
})();
