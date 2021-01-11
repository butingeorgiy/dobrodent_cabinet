export default class EventHandler {
    constructor() {
        this.handlers = {};
    }


    addEvent(node, event, handler, capture = false) {
        if (!(node in this.handlers)) {
            this.handlers[node] = {};
        }

        if (!(event in this.handlers[node])) {
            this.handlers[node][event] = [];
        }

        this.handlers[node][event].push([handler, capture]);
        node.addEventListener(event, handler, capture);
    }

    removeAllListeners(node, event) {
        if (node in this.handlers) {
            const handlers = this.handlers[node];

            if (event in handlers) {
                const eventHandlers = handlers[event];

                for (let i = eventHandlers.length; i--;) {
                    const handler = eventHandlers[i];
                    node.removeEventListener(event, handler[0], handler[1]);
                }
            }
        }
    }
}
