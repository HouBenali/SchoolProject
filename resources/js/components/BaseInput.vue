<template>
    <div class="form-group">
        <label for="">{{ label }}</label>
        <input 
            :type="type"
            v-on:input="$emit('input', $event.target.value)"
            :class="{
                'is-valid':!validator.$error && validator.$dirty,
                'is-invalid':validator.$error
            }"
            class="form-control" 
            />
            <div v-if="validator.$dirty && validator.$error && label=='Nick:' " class="invalid-feedback">
                At least 3 characters
            </div>
            <div v-if="validator.$dirty && validator.$error && label=='Email:' " class="invalid-feedback">
                Please enter a valid email
            </div>
            <div v-if="validator.$dirty && validator.$error && label=='Password:' " class="invalid-feedback">
                At least 8 characters
            </div>
            <div v-if="validator.$dirty && validator.$error && label=='Confirm password:' " class="invalid-feedback">
               The passwords must match
            </div>

    </div>
</template>

<script>
export default {
    props: {
        label: {
            type:String,
            required: true
        },
        type: {
            type: String,
            default: 'text',
            validator (value) {
                return ['text','email','password'].includes(value)
            }
        },
        value: {
            type: String,
            require: true
        },
        validator: {
            type: Object,
            require: true
        }
    }
}
</script>