<div class="form-group">
                            <label for="exampleInputName1">Sub Category</label>
                            
                              <select class="form-control" id="sub-category-type" name="sub_category_type" required>
                                <option value="">Select</option>
                                @if(!empty($subcategories))
				    @foreach ($subcategories as $eachcategory)
					<option value="{{ $eachcategory->_id }}"> 
					    {{ $eachcategory->name }}
					</option>
				    @endforeach   
				    @endif
                              </select>
                            </div>
