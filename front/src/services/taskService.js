import { BASE_URL, HEADERS } from '@/helpers/api';

const BASE_URL_TASKS = `${BASE_URL}/tasks`;

export async function getTask(id) {
  const apiUrl = `${BASE_URL_TASKS}/${id}`;

  try {
    const response = await fetch(apiUrl, {
      method: 'GET',
      headers: HEADERS,
    });
  
    return (await response.json()).data;
  } catch (error) {
    throw new Error('Find error');
  }
}

export async function getTasks() {
  const apiUrl = BASE_URL_TASKS;

  try {
    const response = await fetch(apiUrl, {
      method: 'GET',
      headers: HEADERS,
    });
  
    return response;
  } catch (error) {
    throw new Error('Find error');
  }
}

export async function createTask(task) {
  const apiUrl = BASE_URL_TASKS;
  
  const response  = await fetch(apiUrl, {
    method: 'POST',
    headers: HEADERS,
    body: JSON.stringify({
      title: task.title,
      description: task.description,
    }),
  });

  return response;
}

export async function updateTask(id, task) {
  const apiUrl = `${BASE_URL_TASKS}/${id}`;

  const response = await fetch(apiUrl, {
    method: 'PUT',
    headers: HEADERS,
    body: JSON.stringify({
      title: task.title,
      description: task.description
    }),
  });

  return response;
}

export async function deleteTask(task) {
  const id = task.id;
  const apiUrl = `${BASE_URL_TASKS}/${id}`;

  const response = await fetch(apiUrl, {
    method: 'DELETE',
    headers: HEADERS,
  });

  return response;
}