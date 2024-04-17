import {defineStore} from 'pinia';

export const useModalStore = defineStore('modal', {
  state: () => ({
    updated: 0,
    packages: [],
    show:false,
    data: {},
  }),
  actions: {
    setModal() {
      this.data = {};
      this.show = !this.show;
    }
    ,openModal() {
      this.show = !this.show;
    },
    setData(newData: any) {
        this.data = { ...this.data, ...newData };
    },
    setPackage(newData: any) {
        this.packages = newData;
    },
    setUpdate() {
      this.updated += 1;
      console.log('updated', this.updated);
    },
  },
});