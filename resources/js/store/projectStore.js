import axios from "axios";
import { defineStore } from "pinia";


export const useProjectStore = defineStore('project', {
    state: () => {
        return {
            projectSelected: null,
            project: [],
            loading: false,
            projectDetails: [],
            projectDetailsLoading: false,
            abscisaSelected: null,
            abscisaDetails: [],
            chart: [],
            damageArea: [],
            placaSelectedId: null,
            pathologies: [],
            slabSelected: null,
            projectDetailsPublic: []
        }
    },

    // metodos para obtener los proyectos
    actions: {
        /**
        * Get all projects by user
         * @returns {Promise<void>} - A promise that resolves when the projects are fetched successfully.
         */
        async getProjects() {
            try {
                this.loading = true
                const response = await axios.get('/api/web/projects/index', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });
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
         * get all projects
         */
        async getAllProjects() {
            try {
                const response = await axios.get('/api/list/projects')
                if (response.status === 200) {
                    return response.data;
                }
            } catch (e) {
                console.log(e)
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
         * Get public details of a project.
         * @param {number} id - The ID of the project to fetch public details for.
         */
        async getProjectDetailsPublic(id) {
            try {
                const response = await axios.get(`/api/project/show/${id}`);
                if (response.status === 200) {
                    this.projectDetailsPublic = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },

        /**
         * Set the selected abscissa.
         * @param {Object} abscisa - The selected abscissa object.
         */
        setAbscisaSelected(abscisa) {
            this.abscisaSelected = abscisa;
        },

        /**
         * Get details of the selected abscissa.
         * @param {number} id - The ID of the abscissa to fetch details for.
         * @returns {Promise<void>} - A promise that resolves when the abscissa details are fetched successfully.
         */
        async getChartAbscisaDetails(id) {
            try {
                const response = await axios.get(`/api/abscisa/chart/show/${id}`, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                });
                
                if (response.status === 200) {
                    this.chart = response.data.chart;
                    this.damageArea = [
                        { name: 'Area de daño', data: response.data.damageArea },
                        { name: 'Area de no daño', data: 100 - response.data.damageArea },
                    ];
                }
            } catch (error) {
                console.log(error);
            }
        },

        /**
         * Set the selected placa ID.
         * @param {number} id - The ID of the selected placa.
         */
        setPlacaSelectedId(id) {
            this.pathologies = [];
            this.placaSelectedId = id;
            const slab = this.projectDetails.find(slab => slab.id === this.abscisaSelected.id);

            if (slab) {
                const slabWithPathologies = slab.slabs_with_pathologies.find(slab => slab.id === id);
                if (slabWithPathologies) {
                    this.slabSelected = slabWithPathologies;
                    this.pathologies = slabWithPathologies.pathologies;
                } else {
                    this.pathologies = [];
                }
            }
        }
    }
})