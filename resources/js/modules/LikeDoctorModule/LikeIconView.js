export default class LikeIconView {
    constructor(node) {
        this.node = node;
        this.canLike = true;
    }

    toggle() {
        const span = this.node.querySelector('span');

        if (span) {
            if (this.node.classList.contains('active')) {
                span.innerText = (parseInt(span.innerText, 10) - 1).toString();
            } else {
                span.innerText = (parseInt(span.innerText, 10) + 1).toString();
            }

            this.node.classList.toggle('active');
        }
    }
}
