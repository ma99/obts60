<template>
  <div class="row">
    <div class="card card-light w-100">
      <div class="card-header">
        <!-- <expand :show.sync="show"></expand> -->
        <div class="heading"><slot name="heading"></slot></div>
        <p class="input-group-btn">
          <transition name="fade" mode="out-in">
            <button type="button" @click="expandOrNot()" v-bind:key="expand"
              v-bind:class="{                        
                'btn btn-success': (!expand) ? true : false,          
                'btn btn-warning': (expand) ? true : false,                          
             }" 
            >
              <!-- {{ expand ? 'Save' : 'Edit' }} -->
              <i v-show="expand"class="fas fa-angle-double-up" aria-hidden="true"></i>
              <i v-show="!expand"class="fas fa-angle-double-down" aria-hidden="true"></i>
            </button>
          </transition>
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
      watch: {
        show() {
          this.expand = this.show;
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
  //font-size: 1.2rem;
  letter-spacing: 1px;
  color: gray;
  display: inline-block;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>