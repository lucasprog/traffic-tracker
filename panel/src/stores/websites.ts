import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

const API_URL = import.meta.env.VITE_API_URL

export const useWebSitesStore = defineStore('websites', {
  state: () => ({
    websitesData : [],
    modal: false,
    formEditId: null,
    form: {
      name: null,
      domain: null
    },
    message: {
       type: "",
      message: "",
      title: ""
    }
  }),
  actions:{
    async get(){
      const { status, data } = await axios.get(`${API_URL}/website`, {
        headers: {
          "Accept": "application/json",
          "Content-Type": "application/json"
        }
      });

      if( status === 200 )
      {
        this.websitesData = data;
      }
    },

    async save(){
      const response = await axios.post(`${API_URL}/website`, this.form, {
        headers: {
          "Accept": "application/json",
          "Content-Type": "application/json"
        }
      });

      if( response.status === 201){
        this.message.title = "Congratulations!";
        this.message.message = response.data.message;
        this.message.type = "success";
      }else{
        this.message.title = "Sorry!";
        this.message.message = response.data.message;
        this.message.type = "error";
      }

      let $this = this;
      setTimeout(function(){
        $this.modal = false;
        $this.clearForm();
        $this.clearMessage()
      },3000);

    },
    async update(){
      const response = await axios.put(`${API_URL}/website/${this.formEditId}`, this.form, {
        headers: {
          "Accept": "application/json",
          "Content-Type": "application/json"
        }
      });

      if( response.status === 200){
        this.message.title = "Congratulations!";
        this.message.message = response.data.message;
        this.message.type = "success";
      }else{
        this.message.title = "Sorry!";
        this.message.message = response.data.message;
        this.message.type = "error";
      }

      let $this = this;
      setTimeout(function(){
        $this.modal = false;
        $this.clearForm();
        $this.clearMessage()
      },3000);

    },
    async delete(){
      const response = await axios.delete(`${API_URL}/website/${this.formEditId}`,{
        headers: {
          "Accept": "application/json",
          "Content-Type": "application/json"
        }
      });

      let $this = this;
      setTimeout(function(){
        $this.modal = false;
      },3000);

    },
    openModal(){
      this.clearForm();
      this.modal = true;
    },
    closeModal(){
      this.modal = false;
    },
    clearForm(){
      this.form = {
        name: null,
        domain: null
      }
    },
    clearMessage(){
      this.message = {
        type: "",
        message: "",
        title: ""
      }
    },
    setForm(name, domain){
      this.form.name = name;
      this.form.domain = domain;
    }
  }
})
