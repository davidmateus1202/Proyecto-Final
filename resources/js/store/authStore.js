 import axios from "axios";
import { defineStore } from "pinia";

 export const useAuthStore = defineStore('auth', {
    state: () => {
        return {
            user: {},
            authUser: false
        }
    },

    // actions for auth
    actions: {
        async login(email, password) {
            try {
                const response = await axios.post('/api/login', {
                    email: email,
                    password: password
                });

                if (response.status === 200) {
                    this.user = response.data.user;
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('role', response.data.role[0]);
                    this.authUser = true;
                    return true;
                }

                return false;

            } catch (error) {
                if (error.status === 401) {
                    console.log('Unauthorized');
                    return false;
                }

            }

        }
    },
    persist: true
 })