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

    return await loginApi(userCredential.user.accessToken);
  } catch (error) {
    throw new Error('Auth error');
  }
}

export const logout = async () => localStorage.removeItem('access_token');
