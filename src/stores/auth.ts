import { defineStore } from 'pinia';
import api from './api';
import router from '@/router';
export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token') || null,
    user: JSON.parse(localStorage.getItem('user') || '{}'),
    role: localStorage.getItem('role') || null,
  }),
  actions: {
   login(credentials:any) {
      api.post('/login', credentials).then((response) => {
        this.user = response.data.user;
        this.token = response.data.access_token;
        this.role = response.data.role;
        localStorage.setItem('token', response.data.access_token);
        localStorage.setItem('user', JSON.stringify(response.data.user));
        localStorage.setItem('role', response.data.role);
        router.push("/");
      }
      );
   },
    clearToken() {
      this.token = null;
      localStorage.removeItem('token'); 
    },
    logout() {
      api.get('/logout').then(() => {
      this.clearToken();
      router.push("/signin");
      }
      );
    },
  },
});

