import CartService from "../../services/CartService";

export const state = {
    cartItem: {},
    cart: {
        items: [],
        subtotal: 0,
        discount: 0,
        total: 0,
    }
};

export const mutations = {
    ADD_ITEM_TO_CART(state, item){
        state.cart.items.push(item);
    },
    UPDATE_ITEM(state, item){
        let currentItem = this.getters.getCartItemById(item.product_attribute_id);
        currentItem = item;
    },
    UPDATE_ITEM_QTY(state, item){
        let currentItem = this.getters.getCartItemById(item.product_attribute_id);
        currentItem.product_qty += parseInt(item.product_qty);
    },
    UPDATE_ITEM_PRICE(state, item){
        let currentItem = this.getters.getCartItemById(item.product_attribute_id);
        currentItem.product_price = parseInt(item.product_price);
    },
    REMOVE_ITEM(state, item){
        state.cart.items.splice(state.cart.items.indexOf(item), 1);
    },
    SET_CART(state, cart){
        state.cart = cart;
    },
    UPDATE_CART_SUBTOTAL(state){
        state.cart.subtotal = this.getters.getCartSubTotal;
    },
    UPDATE_CART_TOTAL(state){
        state.cart.total = state.cart.subtotal - state.cart.discount;
    },
    CLEAR_CART(state){
        state.cart.total = 0;
        state.cart.subtotal = 0;
        state.cart.discount = 0;
        state.cart.items = [];
    }
};

export const actions = {
    createCartItem({ commit }, item) {
        //check item is already in cart
        let savedCartItem = this.getters.getCartItemById(item.product_attribute_id);
        if(savedCartItem){
            //update item qty
            let updatedQty = item.product_qty + savedCartItem.product_qty;
            this.dispatch('calcItemPrice', {item, updatedQty});
             CartService.updateCartItemQty(item).then(() => {
                 commit('UPDATE_ITEM_QTY', item);
                 commit('UPDATE_ITEM_PRICE', item);
            });
        }else{
             CartService.setCartItem(item).then(() => {
                commit('ADD_ITEM_TO_CART', item);
            });
        }

        commit('UPDATE_CART_SUBTOTAL');
        commit('UPDATE_CART_TOTAL');
    },
    createCalculatedItemPrice({ commit }, item) {

        this.dispatch('calcItemPrice', {item});
        this.dispatch('createCartItem', item);
    },
    updateItemPriceAfterQtyChanged({ commit }, item) {

        this.dispatch('calcItemPrice', {item});
        commit('UPDATE_ITEM_PRICE', item);
        CartService.setCartItem(item);

    },
    calcItemPrice({ commit }, {item, updatedQty=0}){
        // get base prices defined by admin
        // search for max_qty based on user enter qty
        // calc item price
        // dispatch create item
        let basePrices = item.base_product_prices;
        let qtyIndexSelected = null;
        let itemTotalQty = updatedQty ? updatedQty : item.product_qty;
        let qtyPriceSelected = null;
        let searchQtyDefined = null;
        let definedQty  = Object.keys(basePrices);

        definedQty.forEach(function(value){
            if(parseInt(itemTotalQty) >= value){
                searchQtyDefined = value;
            }
        });

        if(!searchQtyDefined){
            qtyIndexSelected = Math.max.apply(null, definedQty);
        }else{
            qtyIndexSelected = searchQtyDefined;
        }
        qtyPriceSelected = basePrices[qtyIndexSelected];
        console.log(item.product_price);
        item.product_price = parseInt(qtyPriceSelected);
    },
    removeItemFromCart({ commit }, item) {
        //check item is already in cart
        let savedCartItem = this.getters.getCartItemById(item.product_attribute_id);
        if(savedCartItem){
            CartService.removeCartItem(item).then(() => {
                commit('REMOVE_ITEM', item);
            });
        }else{
            console.log('item already deleted');
        }
    },
    fetchCart({ commit }, { id }) {
        CartService.getUserCart(id)
            .then(response => {
                commit('SET_CART', response.data)
            })
            .catch(error => {
                console.log('There was an error:', error.response)
            })
    },
    clearCart({ commit }) {
        commit('CLEAR_CART');
    }
};
export const getters = {
    getCartItemById: state => id => {
        return state.cart.items.find(cart => cart.product_attribute_id === id)
    },
    getCartSubTotal: state => {
        let subTotal = 0;
        state.cart.items.forEach(item =>  subTotal += (item.product_qty * item.product_price));

        return subTotal;
    }
};
