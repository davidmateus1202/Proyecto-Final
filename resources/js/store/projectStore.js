import axios from "axios";
import { defineStore } from "pinia";


export const useProjectStore = defineStore('project', {
    state: () => {
        return {
            project: [],
            loading: false
        }
    },

    // metodos para obtener los proyectos
    actions: {
        async getProjects() {
            try {
                this.loading = true
                const response = await axios.get('/api/web/projects/index', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });
                console.log(response);
                if (response.status === 200) {
                    this.project = response.data['data'];
                }
                
            } catch (error) {
                this.project = []
                console.log(error);
            } finally {
                this.loading = false;
            }
        }
    }
})