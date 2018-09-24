<template>
	<div>
		<div v-show="state === 'default'">
			<v-layout row wrap>
	    		<v-flex xs10 offset-sm1>
	      			<v-card>	      					       
				        <v-card-title primary-title>
				          <div>
				            <h3>{{ comment.user.name }}</h3>
				            <div>{{ comment.text }}</div>
				          </div>
				        </v-card-title>
				        <v-card-actions>
				          <v-btn v-if="editable" @click="state='editing'" class="white--text" color="orange">Редактировать</v-btn>				          
				        </v-card-actions>
				      </v-card>
	    		</v-flex>
	  		</v-layout>			
  		</div>
  		<div v-show="state==='editing'">
  			<v-layout row wrap>
		  	  	<v-flex xs10 offset-xs1>
		  	  		 <v-card>				        
				        <v-card-title primary-title>				          				
				            <v-textarea
						          solo
						          name="input-7-4"
						          label="Редактировать комментарий"
						          v-model="data.text"
						    ></v-textarea>				          
				        </v-card-title>				   
				        <v-card-actions>
				          <v-btn class="white--text" color="purple" @click="saveEdit">Редактировать</v-btn>
				          <v-btn class="white--text" color="purple" @click="resetEdit">Отменить</v-btn>				          
				          <v-btn class="white--text" color="red" @click="deleteComment">Удалить</v-btn>				          
				        </v-card-actions>				        
				     </v-card>		  	  		
		  	  	</v-flex>
		  	</v-layout>
  		</div>		  				
	</div>	
</template>
<script>
	export default {
		props:{
			user:{
				required: true,
				type: Object
			},

			comment:{
				required: true,
				type: Object
			}
		},

		data() {
			return {
				state: 'default',
				data: {
					text: this.comment.text
				}
			}
		},

		computed:{
			editable() {
				return this.user.id === this.comment.user.id
			}
		},		

		methods:{
			resetEdit() {
				this.state = 'default'
				this.data.text = this.comment.text
			},

			saveEdit() {
				this.state = 'default'
				this.$emit('comment-updated', {
					'id': this.comment.id,
					'text': this.data.text
				})
			},

			deleteComment() {				
				this.$emit('comment-deleted', {
					'id': this.comment.id
				})
			}			
		}
	}
</script>