import { defineStore } from "pinia";

const useEventsStore = defineStore({
    id: "events",
    state: () => ({
        events: [] as any[] 
    }),
    actions: {
        addEvent(event: any) {  
            this.events.push(event);
        },
    },
});
export default useEventsStore;
