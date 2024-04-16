// JavaScript BLOCKS Document
const {useBlockProps} = wp.blockEditor;
const {__experimentalLinkControl } = wp.blockEditor;
const LinkControl = __experimentalLinkControl;
const {TextControl, SelectControl, PanelBody, PanelRow, Autocomplete} = wp.components;
const {registerBlockType} = wp.blocks;
const {Component} = wp.element;

registerBlockType('cq/title-separator', {
  title: 'Title Separator',
  icon: 'minus',
  category: 'common',
  attributes: {
    separator_title: {
      type: 'string',
    },
    see_more_link: {
      type: 'object',
    },
  },
  edit: ( {attributes, setAttributes} ) => {
      
    const blockProps = useBlockProps( {
    } );
      
    const onChangeSeparatorTitle = value => {
        setAttributes({ separator_title: value });
     
    };
      
    const onChangeSeeMore = value => {
        setAttributes({ see_more_link: value });
    };
  
    return (
      <div { ...blockProps} style={{padding: "0 1rem 1rem", backgroundColor: "#f2f2f9", border: "1px solid #ccc"}}>
          <h3>Title Separator</h3>
          <div>
          <TextControl
              label="Separator Title"
              name="separator_title"
              id="separator_title"
              value={attributes.separator_title}
              onChange={onChangeSeparatorTitle}
              onLoad={onChangeSeparatorTitle}
          />
          </div>
          <div>
          <LinkControl
              label="See More Link"
              name="see_more_link"
              id="see_more_link"
              placeholder="See More Link"
              value={attributes.see_more_link}
              onChange={onChangeSeeMore}
              onLoad={onChangeSeeMore}
          />
          </div>
      </div>
    );
  },
  save: function() {
    return null;
  },
});