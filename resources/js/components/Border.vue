<template>
  <div v-bind:style="border"
    v-bind:class="{                        
          'navy-blue': (color == 'navy-blue') ? true : false,          
          'eastern-blue': (color == 'eastern-blue') ? true : false,          
          'pigment-green': (color == 'pigment-green') ? true : false,          
          'orange-yellow': (color == 'orange-yellow') ? true : false,          
          'orange-red': (color == 'orange-red') ? true : false,          
       }" 
  >
    <span v-bind:style="heading" v-show="headingShow">        
        <slot name="heading"></slot>        
    </span>
    <slot></slot>
  </div>
</template>

<script>
    export default {
        props: ['color', 'pattern', 'width', 'headingBackground', 'headingWidth', 'headingShow'],
        data() {
            return {                
              border: {
                borderWidth: '1px',
                borderStyle: 'dashed',
                //border-color: lightblue,
                padding: '35px 10px 15px',
                margin: '25px auto 50px',
                position: 'relative',
              },   

              heading: {
                backgroundColor: 'lightblue', 
                display: 'block',
                fontWeight: 600,
                letterSpacing: '1px',        
                left: '14px',
                top: '-16px',
                textAlign: 'center',
                position: 'absolute',
                padding: '5px 10px',
                width: '125px',
              }      
            }                          
        },
        mounted() {            
            this.border.borderWidth = this.width + 'px';            
            this.border.borderStyle = this.pattern;
            
            this.heading.backgroundColor = this.headingBackground;
            this.heading.width = this.headingWidth + 'px';

        },
    }
</script>
<style lang="scss" scoped>
  $navy-blue: #0477BF;
  $eastern-blue: #0396A6;
  $pigment-green: #04BF55;
  $orange-yellow: #F2B705;
  $orange-red: #F24405;
  
  .navy-blue {    
    border-color: $navy-blue;
  }
  .eastern-blue {    
    border-color: $eastern-blue;
  }
  .pigment-green {    
    border: $pigment-green;
  }
  .orange-yellow {    
    border: $orange-yellow;
  }
  .orange-red {    
    border: $orange-red;
  }  
</style>