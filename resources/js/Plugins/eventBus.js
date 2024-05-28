import mitt from 'mitt'
const emitter = mitt();

const EventBusPlugin = {
    install(app) {
        app.config.globalProperties.$eventBus = {
            emit(event, data){
                emitter.emit(event, data);
            },
            on(event, callback){
                emitter.on(event, callback);
            },
        }
    }
};

export default EventBusPlugin;
