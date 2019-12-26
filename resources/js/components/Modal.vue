<template>
  <!-- <div id="modal" class="modal" v-show="show">
    <div class="modal-content">
      <div class="circle">
          <span class="close" data-toggle="tooltip" data-placement="top" title="Press esc to close" @click="close()">x</span>                  
      </div>         
      <slot></slot>      
    </div>          
  </div> -->
  
  <!-- Modal -->
<div v-show="show" class="modal fade" id="modalComponent" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalComponentLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalComponentLabel">
          <slot name="title"></slot>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <slot></slot>  
      </div>
      <div class="modal-footer">
        <slot name="footer"></slot>
      </div>
    </div>
  </div>
</div>   
</template>

<script>
    export default {
      props: ['show'],                  
      created() {
          document.addEventListener("keydown", (e) => {
            if (e.keyCode == 27) {
              this.close();
            }
          });
        },
      mounted() {
          console.log('model component mounted.')
      },
      methods: {
        close() {                
                //this.$emit('close');                
                this.$emit('update:show', false); 
            },
      }      
    }
</script>
<style lang="scss" scoped>
    /* The Modal (background) */
    
</style>