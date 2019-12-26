<template>
    <div>
      <span class="input-group-btn">
        <button class="btn btn-success" type="button" @click="expandOrNot()" v-show="!expand">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </button>
        <button class="btn btn-warning" type="button" @click="expandOrNot()" v-show="expand">
            <i class="fa fa-minus" aria-hidden="true"></i>
        </button>
      </span>                
    </div>
</template>

<script>
    export default {            
      props: ['show'],      
      data() {
        return {
          expand: '',
        }
      },

      methods: {        
        expandOrNot()  {
          this.expand = !this.expand;
          this.$emit('update:show', this.expand);          
        },         
      },
      mounted() {
          //console.log('expandOrNot Component mounted.');        
          this.expand = this.show;
      },
    }
</script>
<style lang="scss" scoped>  
</style>