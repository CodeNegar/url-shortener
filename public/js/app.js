Vue.component('url-shortener-form',{

    template: `<form class="form-shorten">
      <h1 class="h3 mb-3 font-weight-normal">Please Enter your URL</h1>
      <label for="input-shorten" class="sr-only">Long URL</label>
      <input type="url" class="form-control mb-3" placeholder="http://" name="input-shorten" id="input-shorten" :readonly="is_loading" v-model="longurl" required autofocus>
      <button :class="{ 'progress-bar-striped progress-bar-animated': is_loading }" :disabled="is_loading" class="btn btn-lg btn-primary btn-block mb-3" id="button-shorten" v-on:click="clickHandler" type="submit">Shorten</button>
      <div id="response-shorten" class="alert alert-primary" :class="{'alert-success': is_error == false, 'alert-danger': is_error == true }" v-show="results.length" role="alert" v-html="results"></div>
    </form>`,

    data(){
        return {
            longurl: '',
            is_error: false,
            is_loading: false,
            results: '',
        };
    },

    methods:{
        clickHandler(e) {
            e.preventDefault();
            this.reset_state();
            this.is_loading = true;
            axios.post('api/urls', {
                longurl: this.longurl
            })
            .then(res => {
                console.log(res);
                this.is_error = false;
                this.longurl = '';
                this.is_loading = false;
                this.results = res.data.message + '<br>' + res.data.data.short_url + '<br>' + res.data.data.stats;
            })
            .catch(error => {
                this.is_error = true;
                this.is_loading = false;
                this.results = error.response.data.message;
            });
        },

        reset_state(){
            this.is_error = false;
            this.results = '';
        }
    }

});

let UrlShortener = new Vue({
	el: '#app',
	data: {

    },

	mounted(){
	    // todo: get latest shortened links
	},


});