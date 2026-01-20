export default function Container ({ children, className = "" }) {
    return (
        <div className={className + " custom-container"}>
            {children}
        </div>
    )
}  