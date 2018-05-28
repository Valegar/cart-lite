import $ from 'jquery'
import Vue from 'vue'
import Router from '../Router'

new Vue({
    delimiters: ['${', '}'],
    el: '#product-view',
    data () {
        return {
            quantity: 1
        }
    },
    methods: {
        addQuantity (adding) {
            this.quantity += adding;
            // The quantity should be positive
            if (this.quantity <= 0) {
                this.quantity = 1;
            }
        },
        addToCart (id) {
            let url = Router.generate('cart_edit', {id, quantity: this.quantity});
            $.get(url).then(response => {
                window.location = Router.generate('cart_show');
            })
        }
    }
});
