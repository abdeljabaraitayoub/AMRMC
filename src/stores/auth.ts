import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token') || null,
  }),
  actions: {
    setToken(newToken:string) {
      this.token = newToken;
      localStorage.setItem('token', newToken);
    },
    clearToken() {
      this.token = null;
      localStorage.removeItem('token');
    },
  },
});

