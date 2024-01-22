import { BASE_URL } from '@/helpers/api';
import { getAuth, signInWithEmailAndPassword } from 'firebase/auth';

export async function loginApi(accessToken) {
  const apiUrl = `${BASE_URL}/login`;

  const response = await fetch(apiUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({token: accessToken}),
  });

  return response;
}

export async function loginFirebase(email, password) {
  const auth = getAuth();
  try {
    const userCredential = await signInWithEmailAndPassword(auth, email, password);

    localStorage.userUid = userCredential.user.uid;

    return await loginApi(userCredential.user.accessToken);
  } catch (error) {
    console.log('aki');
    console.log(error);
    throw new Error('Auth error');
  }
}

export async function logout ()  {
  localStorage.removeItem('access_token');
  localStorage.removeItem('userUid');
} 
