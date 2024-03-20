import {defineStore} from 'pinia'

export const userStore = defineStore('auth', {
    state: () => {
        return {
            user: null,
            pharmacy:null,
            PharmacyUser:null
        }
    },
    getters: {
        isLoggedIn: (state) => {
            return !!state.user?.token;
        },
        getUser: (state) => {
            return state.user;
        },
        getRoles: (state) => {
            return state.user?.roles;
        },
    },
    actions: {
        setUser(data) {
            this.user = data;
            localStorage.setItem('user', JSON.stringify(data));
            if(data == null){
                localStorage.setItem('pharmacyUser', null);
            }else{
                localStorage.setItem('pharmacyUser', JSON.stringify(data.pharmacy_id));
            }
            
        },
        getUserFromLocalStorage() {
            const userData = localStorage.getItem('user');
            if (userData === null) {
                return;
            }
            this.user = JSON.parse(userData);
        },
    },
});
