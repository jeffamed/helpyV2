<template>

        <a class="nav-link link" href="#">
                <i class="fa fa-bell-o" aria-hidden="true"></i>
                <div class="notification-badge" v-if="count!=0">{{ count.data }}</div>
        </a>

</template>

<script>

    export default {
        data() {
          return {
                count: 0,
          }
        },
        watch:{
            'count': function (newVal, oldVal) {
               console.log(newVal.data);
            },
        },
        mounted() {
            this.notifyCount();
        },
        methods: {
            async notifyCount (){
                const result = await  axios.get('/count')
                this.count = result;//console.log(result);
            },
        }
    }
</script>
