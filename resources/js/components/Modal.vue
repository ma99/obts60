<template>   
<!-- Modal -->
<div v-show="show">
<transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <!-- <div class="modal-container"> -->
        <div id="modal-container" v-bind:style="modalContainer">
          <div class="modal-header">
            <slot name="header">
              <!-- default header -->
              <!-- <button class="modal-default-button" @click="$emit('close')">
                OK
              </button> -->
              <button type="button" class="close" @click="close()">
                <span aria-hidden="true">&times;</span>
              </button>
            </slot>
          </div>

          <div class="modal-body">
            <slot></slot>
          </div>

          <div class="modal-footer">
            <slot name="footer">
              <!-- default footer -->
            </slot>
          </div>
        </div>
      </div>
    </div>
</transition>
</div>
</template>

<script>
    export default {
      props: ['show', 'width', 'padding'],
      data() {
        return {
          modalContainer: {
            width: '30rem',
            margin: '1.75rem auto',
            padding: '1rem',
            backgroundColor: '#fff',
            borderRadius: '3px',
            boxShadow: '0 2px 8px rgba(0, 0, 0, .33)',
            transition: 'all .3s ease',
            height: 'calc(100vh - 4rem)',
            overflowY: 'auto',
          }
        }
      },                 
      created() {
          document.addEventListener("keydown", (e) => {
            if (e.keyCode == 27) {
              this.close();
            }
          });
        },
      mounted() {
          if (this.width) {            
            this.modalContainer.width = this.width + 'rem';            
          }          
          if (this.padding) {            
            this.modalContainer.padding = this.padding + 'rem';
          }
          //this.enableScroll();
      },
      methods: {
        close() {                
                //this.$emit('close');                
                this.$emit('update:show', false); 
        },
        // enableScroll() {
        //     //initializes the plugin with empty options
        //   $('#modal-container').overlayScrollbars({ /* your options */ 
        //     sizeAutoCapable: false,
        //     scrollbars: {
        //       autoHide: "never",
        //       clickScrolling: true
        //     }
        //   }); 
        // },
      }      
    }
</script>
<style lang="scss" scoped>
    /* The Modal (background) */
  .modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

// .modal-container {
//   width: 31rem;
//   margin: 1.75rem auto;
//   padding: 20px 30px;
//   background-color: #fff;
//   border-radius: 3px;
//   box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
//   transition: all .3s ease;
//   height: calc(100vh - 0px);
//   overflow-y: auto;
//   //font-family: Helvetica, Arial, sans-serif;
//}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;  
}

.modal-body {
  margin: 1rem 0; //20px 0;  
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}    
</style>