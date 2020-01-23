<template>
  <div class="row">
    <div class="card card-light w-100">
      <div class="card-header">
        <!-- <expand :show.sync="show"></expand> -->
        <div class="heading"><slot name="heading"></slot></div>
        <p class="input-group-btn">
          <button class="btn btn-success" type="button" @click="expandOrNot()" v-show="!expand">
              <i class="fa fa-plus" aria-hidden="true"></i>
          </button>
          <button class="btn btn-warning" type="button" @click="expandOrNot()" v-show="expand">
              <i class="fa fa-minus" aria-hidden="true"></i>
          </button>
        </p>                
      </div>            
      
      <div class="card-body" v-show="expand">        
        <slot></slot>         
      </div>
      
      <div class="card-footer">
        <slot name="footer"></slot>        
      </div>                        
    </div>
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
div.card-header p {    
    float: right;
    margin: 0;    
}  
div.heading {
  margin-top: 5px; 
  font-size: 1.2rem;
  letter-spacing: 1px;
  color: gray;
  display: inline-block;
}
</style>