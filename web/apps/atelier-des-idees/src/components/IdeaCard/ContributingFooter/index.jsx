import React from "react";
import PropTypes from "prop-types";
import classnames from "classnames";

function ContributingFooter(props) {
    return (
        <div className="contributing-footer">
            {/* TODO: implement report */}
            {/* <button className="contributing-footer__report" onClick={() => alert("Hello je sigale")}>Signaler</button> */}
            <div className="contributing-footer__remaining-days">
                <img className="contributing-footer__remaining-days__icon" src="/assets/img/icn_hourglass.svg"/>
                <span className="contributing-footer__remaining-days__text">{props.remainingDays}</span>
            </div>
            <button className="contributing-footer__link" onClick={() => alert("Hello je contribue")}>+ Je contribue</button>
        </div>
    );
}

ContributingFooter.propTypes = {
    remainingDays: PropTypes.string.isRequired,
    link: PropTypes.string.isRequired,
}

export default ContributingFooter;