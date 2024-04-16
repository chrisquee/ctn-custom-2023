// JavaScript BLOCKS Document
const {useBlockProps} = wp.blockEditor;
const {TextControl, SelectControl, PanelBody, PanelRow, Autocomplete} = wp.components;
const {registerBlockType} = wp.blocks;
const {Component} = wp.element;

registerBlockType('cq/events-block', {
  title: 'Events Block',
  icon: 'list-view',
  category: 'common',
  attributes: {
    max_events: {
      type: 'string',
    },
    event_id: {
      type: 'string',
    },
  },
  edit: ( {attributes, setAttributes} ) => {
      
    const blockProps = useBlockProps( {
      className: 'cq-h1',
      'data-id': 'h1-id',
    } );
      
    console.log(attributes.event_id);
      
    var events = wp.data.select('core').getEntityRecords('postType', 'events', { per_page: 10 });
    var eventOptions = [{value: '',
                         label: 'Any'}];
      
    if (events) {
        for (var i = 0; i < events.length; i++) {
            var option = { 
                            value: events[i].id ,
                            label: events[i].title.rendered
                        };
            eventOptions.push(option);
        }
    }
      
    const onChangeMaxEvents = value => {
        setAttributes({ max_events: value });
     
    };
      
    const onChangeEventId = value => {
        setAttributes({ event_id: value });
    };
  
    return (
      <div { ...blockProps} style={{padding: "0 1rem 1rem", backgroundColor: "#f2f2f9", border: "1px solid #ccc"}}>
          <h3>Events List Block</h3>
          <div>
          <SelectControl
              label="Max Events to show"
              name="max_events"
              id="max_events"
              value={attributes.max_events}
              options={ [
                  { value: '1', label: '1', id: 1 },
                  { value: '4', label: '4', id: 2 },
                  { value: '7', label: '7', id: 3 },
              ] }
              onChange={onChangeMaxEvents}
              onLoad={onChangeMaxEvents}
          />
          </div>
          <div>
          <SelectControl
              label="Choose single event"
              name="event_id"
              id="event_id"
              value={attributes.event_id}
              options={eventOptions}
              onChange={onChangeEventId}
              onLoad={onChangeEventId}
          />
          </div>
      </div>
    );
  },
  save: function() {
    return null;
  },
});