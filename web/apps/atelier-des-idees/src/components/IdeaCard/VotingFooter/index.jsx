import React from "react";
import PropTypes from "prop-types";
import classnames from "classnames";

class VotingFooter extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            toggleVotes: false,
        };
    }

    render() {
        return (
            <div className="voting-footer">
                <div className="voting-footer__label">
                    <div className="voting-footer__label__text">Je vote :</div>
                    <button
                        className={classnames('voting-footer__label__action', {
                            rotate: this.state.toggleVotes,
                        })}
                        onClick={() => this.setState((prevState) => ({ toggleVotes: !prevState.toggleVotes }))}>
                        >
                    </button>
                </div>
                {
                    this.props.votes.map((vote) => {
                        return (
                            <button key={vote.id} className={classnames('voting-footer__vote', {
                                'voting-footer__vote--selected': vote.isSelected,
                                hidden: !this.state.toggleVotes,
                            })} onClick={() => this.props.onSelected(vote.id)}>
                                <span className="voting-footer__vote__name">{vote.name}</span>
                                <span className="voting-footer__vote__count" >{vote.count}</span>
                            </button>
                        );
                    })
                }
            </div>
        );
    }
    
}

VotingFooter.propTypes = {
    votes: PropTypes.arrayOf(PropTypes.shape({
        id: PropTypes.string.isRequired,
        name: PropTypes.string.isRequired,
        count: PropTypes.number.isRequired,
        isSelected: PropTypes.bool.isRequired,
    })).isRequired,
    onSelected: PropTypes.func.isRequired,
};

export default VotingFooter;