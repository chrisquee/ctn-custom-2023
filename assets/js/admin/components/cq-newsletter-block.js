// JavaScript BLOCKS Document
const {useBlockProps} = wp.blockEditor;
const {TextControl, SelectControl, PanelBody, PanelRow, Autocomplete, ResponsiveWrapper, Button} = wp.components;
const {InspectorControls, InnerBlocks, MediaUpload, MediaUploadCheck} = wp.editor;
const {registerBlockType} = wp.blocks;
const {Component} = wp.element;

registerBlockType('cq/newsletter-block', {
  title: 'Newsletter Block',
  icon: 'email',
  category: 'common',
  attributes: {
    style: {
      type: 'string',
    },
    title: {
      type: 'string',
    },
    subtitle: {
      type: 'string',
    },
    block_image: {
      type: 'number',
      default: 0,
    },
    block_image_url: {
        type: 'string',
        default: '',
    },
    el_class: {
      type: 'string',
      default: '',
    },
  },
  edit: ( {attributes, setAttributes} ) => {
      
    const blockProps = useBlockProps( {
      className: 'cq-h1',
      'data-id': 'h1-id',
    } );
      
    const ALLOWED_MEDIA_TYPES = [ 'image' ];                        
      
      
    const onChangeStyle = value => {
        setAttributes({ style: value });
     
    };
      
    const onChangeTitle = value => {
        setAttributes({ title: value });
    };
      
    const onChangeSubTitle = value => {
        setAttributes({ subtitle: value });
    };
      
    const onUpdateImage = (media) => {
        setAttributes({ block_image: media.id,
                        block_image_url: media.url});
    }
    
    const removeImage = () => {
    	setAttributes({
    		block_image:  0,
    		block_image_url: ''
    	});
    }
  
    return (
      <div { ...blockProps} style={{padding: "0 1rem 1rem", backgroundColor: "#f2f2f9", border: "1px solid #ccc"}}>
          <h3>Newsletter Block</h3>
          <div>
          <SelectControl
              label="Style"
              name="style"
              id="style"
              value={attributes.style}
              options={ [
                  { value: 'standard', label: 'Standard', id: 1 },
                  { value: 'slim', label: 'Slim', id: 2 },
                  { value: 'split', label: 'split', id: 3 },
              ] }
              onChange={onChangeStyle}
              onLoad={onChangeStyle}
          />
          </div>
          <div>
            <TextControl
              label="Title"
              name="title"
              id="title"
              value={attributes.title}
              onChange={onChangeTitle}
              onLoad={onChangeTitle}
          />
          </div>
          <div>
            <TextControl
              label="Subtitle"
              name="subtitle"
              id="subtitle"
              value={attributes.subtitle}
              onChange={onChangeSubTitle}
              onLoad={onChangeSubTitle}
          />
          </div>
          <div className="wp-block-image-selector-example-image">
            <MediaUploadCheck>
                <MediaUpload
                  title={ __( 'Background image', 'CQ_Custom' ) }
                  onSelect={ onUpdateImage }
                  allowedTypes={ ALLOWED_MEDIA_TYPES }
                  value={ attributes.block_image }
                  render={ ( { open } ) => (
                    <Button
                        className={ 'editor-post-featured-image__toggle' }
                        onClick={ open }>
                        { __( 'Set background image', 'CQ_Custom' ) }
                    </Button>
                 ) }
               />
            </MediaUploadCheck>
            <ResponsiveWrapper>
    			<img src={attributes.block_image_url} />
    		</ResponsiveWrapper>
            {attributes.block_image != 0 && 
			 <MediaUploadCheck>
				<Button onClick={removeImage} isLink isDestructive>{__('Remove image', 'CQ_Custom')}</Button>
			 </MediaUploadCheck>
		  }
		</div>             
      </div>
    );
  },
  save: function() {
    return null;
  },
});