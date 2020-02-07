<template>
    <input type="text" 
        v-bind:value="value"
        v-on:input="$emit('input', $event.target.value)">         
    </input>
</template>

<script>
    export default {
        props: ['value'],
        data() {
            return {                              
            }
        },
        mounted() {
            //console.log('Component mounted.')                        
        },        
    }
</script>