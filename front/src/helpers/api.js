export const BASE_URL = process.env.VUE_APP_BASE_URL;

export const HEADERS ={
  'Authorization': 'Bearer ' + localStorage.access_token,
  'Content-Type': 'application/json',
};