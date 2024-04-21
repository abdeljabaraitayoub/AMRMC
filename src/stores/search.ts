import { defineStore } from "pinia";
export const searchstore = defineStore("search", {
    state: () => ({
        value: 'test',
    }),
    actions: {
        setSearch(newData: string) {
        this.value = newData;
        },
    },
    });
