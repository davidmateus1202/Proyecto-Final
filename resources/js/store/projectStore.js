import axios from "axios";
import { defineStore } from "pinia";


export const useProjectStore = defineStore('project', {
    state: () => {
        return {
            project: [],
            loading: false,
            projectDetails: [],
            projectDetailsLoading: false,
            abscisaSelected: null,
        }
    },

    // metodos para obtener los proyectos
    actions: {
        /**
        * Get all projects
         * @returns {Promise<void>} - A promise that resolves when the projects are fetched successfully.
         */
        async getProjects() {
            try {
                this.loading = true
                const response = await axios.get('/api/web/projects/index', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });
                console.log(response);
                if (response.status === 200) {
                    this.project = response.data['data']['data'];
                }
                
            } catch (error) {
                this.project = []
                console.log(error);
            } finally {
                this.loading = false;
            }
        },

        /**
         * get details of a project
         * @param {number} id - The ID of the project to fetch details for.
         */
        async getProjectDetails(id) {
            try {
                this.projectDetailsLoading = true
                const response = await axios.post('/api/web/projects/show', { project_id: id}, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });

                if (response.status === 200) {
                    this.projectDetails = response.data.data['data'];
                } else {
                    this.projectDetails = []
                }

            } catch (error) {
                console.log(error);
            } finally {
                this.projectDetailsLoading = false;
            }
        },

        /**
         * Set the selected abscissa.
         * @param {Object} abscisa - The selected abscissa object.
         */
        setAbscisaSelected(abscisa) {
            this.abscisaSelected = abscisa;
            console.log(this.abscisaSelected);
        }
    }
})