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
        let currentItem = this.getters.getCartItem(item);
        currentItem = item;
    },
    UPDATE_ITEM_QTY(state, item){
        let currentItem = this.getters.getCartItem(item);
        currentItem.product_qty += parseInt(item.product_qty);
    },
    UPDATE_ITEM_PRICE(state, item){
        let currentItem = this.getters.getCartItem(item);
        currentItem.product_price = parseInt(item.product_price);
    },
    REMOVE_ITEM(state, item){
        state.cart.items.splice(state.cart.items.indexOf(item), 1);
    },
    SET_CART(state, cart){

        cart.items.forEach(function(item){
            state.cart.items.push(item);
        });

        state.cart.subtotal = cart.subtotal;
        state.cart.discount = cart.discount;
        state.cart.total = cart.total;
    },
    UPDATE_CART_SUBTOTAL(state){
        state.cart.subtotal = this.getters.getCartSubTotal;
    },
    UPDATE_CART_TOTAL(state){
        state.cart.total = state.cart.subtotal - state.cart.discount;
    },
    CLEAR_CART(state){

        // state.cart.items.forEach(function(item){
        //     // state.cart.items.splice(state.cart.items.indexOf(item), 1);
        //     state.cart.items.pop();
        // });

        state.cart.items = [];
        state.cart.total = 0;
        state.cart.subtotal = 0;
        state.cart.discount = 0;
        state.cartItem = {};
    }
};

export const actions = {
    createCartItem({ commit }, item) {
        //check item is already in cart
        let savedCartItem = this.getters.getCartItem(item);

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
    createCartItemAlreadyUploaded({ commit }, item) {
        //check item is already in cart
        let savedCartItem = this.getters.getCartItem(item);

        if(savedCartItem){
            //update item qty
            let updatedQty = item.product_qty + savedCartItem.product_qty;
            this.dispatch('calcItemPrice', {item, updatedQty});
            CartService.updateCartItemQty(item).then(() => {
                commit('UPDATE_ITEM_QTY', item);
                commit('UPDATE_ITEM_PRICE', item);
            });
        }else{
            commit('ADD_ITEM_TO_CART', item);
        }

        commit('UPDATE_CART_SUBTOTAL');
        commit('UPDATE_CART_TOTAL');
    },
    createCalculatedItemPrice({ commit }, item) {
        this.dispatch('calcItemPrice', {item});
        this.dispatch('createCartItem', item);
    },
    createCalculatedItemPriceAlreadyUploaded({ commit }, item) {
        this.dispatch('calcItemPrice', {item});
        this.dispatch('createCartItemAlreadyUploaded', item);
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
        qtyPriceSelected = basePrices[qtyIndexSelected]['price'];
        item.product_price = parseInt(qtyPriceSelected);
        if(parseInt(basePrices[qtyIndexSelected]['discount']) > 0){
            item.product_discount = parseInt(qtyPriceSelected) - parseInt(basePrices[qtyIndexSelected]['discount']);
        }else{
            item.product_discount = parseInt(basePrices[qtyIndexSelected]['discount']);
        }

    },
    removeItemFromCart({ commit }, item) {
        //check item is already in cart
        let savedCartItem = this.getters.getCartItem(item);
        if(savedCartItem){
            CartService.removeCartItem(item).then(() => {
                commit('REMOVE_ITEM', item);
            });
        }else{
            console.log('item already deleted');
        }
    },
    fetchCart({ commit } ) {
        CartService.getUserCart()
            .then(response => {
                commit('SET_CART', response.data)
            })
            .catch(error => {
                console.log('There was an error:', error.response)
            })
    },
    setCart({ commit }, cart ) {
        commit('SET_CART', cart);
    },
    clearCart({ commit }) {
        commit('CLEAR_CART');
    },
    getStockInCart({ commit }, id) {
        let totalQty = this.getters.getCartItemQtyById(id);

        if(totalQty){
            return totalQty;
        }

        return 0;
    }
};
export const getters = {
    getCartItem: state => item => {
        return state.cart.items.find(cart => (cart.product_attribute_id === item.product_attribute_id && cart.product_print_image === item.product_print_image ) )
    },
    getCartItemQtyById: state => id => {
        let total = 0;
        state.cart.items.forEach(function(itemCart){
            if(itemCart.product_attribute_id == id){

                total += itemCart.product_qty
            }
        });

        return total;
    },
    getCartSubTotal: state => {
        let subTotal = 0;
        state.cart.items.forEach(item =>  subTotal += (item.product_qty * item.product_price));

        return subTotal;
    }
};
