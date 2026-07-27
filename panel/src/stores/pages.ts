import { defineStore } from 'pinia'

import {useWebSitesStore} from "./websites.ts";

import axios from 'axios'

const API_URL = import.meta.env.VITE_API_URL

export const usePagesStore = defineStore('pages', {
  state: () => ({
    websiteId: null,
    pagesData: [],
    form: {
      start_at: null,
      end_at: null
    }
  }),
  actions: {
    async get(){
      const url = this.websiteId? `${API_URL}/pages/${this.websiteId}` : `${API_URL}/pages/all`;
      const { status, data }  = await axios.get(url,{
        headers: {
          "Accept": "application/json",
          "Content-Type": "application/json"
        },
        params: this.form
      });

      if( status === 200 )
      {
        this.pagesData = data;
      }
    },
    findWebsite(websiteId){
      return useWebSitesStore().websitesData.find((web) => web.id === websiteId);
    }
  }
});
